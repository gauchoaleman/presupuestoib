<?php

namespace App\Http\Controllers\Budget\View\Common;

use App\Http\Controllers\Controller;
use App\Classes\Calculation\Common\CommonCalculation;
use Illuminate\Http\Request;
use DB;

class ShowJob extends Controller
{
  private function get_result_from_db( $common_job_id,$actual_dollar )
  {
    $common_job = DB::table('common_jobs')->
    join('paper_prices', 'common_jobs.paper_price_id', '=', 'paper_prices.id')->
    select('common_jobs.*','paper_prices.paper_type_id','paper_prices.paper_color_id','paper_prices.weight')->where('common_jobs.id','=', $common_job_id)->first();
    $ret["all_input"] = (array) $common_job;
    if( $actual_dollar )
      $ret["all_input"]["dollar_price_id"] = get_actual_dollar_price_id();
    $ret["all_input"]["common_job_id"] = $common_job_id;
    $common_calculation = new CommonCalculation();
    $ret["result"] = $common_calculation->calculate_result($ret["all_input"]);
    //print_r($ret);      //Bandera
    return $ret;
  }

  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request,$common_job_id)
  {
    if(isset($_GET["actual_dollar"]) )
      $actual_dollar = true;
    else
      $actual_dollar = false;

    $data = $this->get_result_from_db($common_job_id,$actual_dollar);

    if( isset($_POST["button_action"]) && $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/view/common/show_job_paper","",$data);
    else
      return $this->show_page_with_menubars("budget/view/common/show_job","",$data);
  }
}
