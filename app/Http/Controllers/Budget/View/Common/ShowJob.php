<?php

namespace App\Http\Controllers\Budget\View\Common;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Budget\Calculate\Common\ShowResult;
use App\Classes\CommonCalculation;
use Illuminate\Http\Request;
use DB;

class ShowJob extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function __invoke(Request $request)
  {
    $test_common_calculation = new CommonCalculation();
    if( isset($_GET["common_job_id"]) ){
      $data = $this->get_result_from_db($_GET["common_job_id"]);
      if( isset($_POST["button_action"]) && $_POST["button_action"] == "show_job_paper" )
        return $this->show_page_without_menubars("budget/calculate/common/show_job_paper","",$data);
      else
        return $this->show_page_with_menubars("budget/calculate/common/show_result","",$data);
    }
    else
      return $this->show_page_with_menubars("/home_page","No se puede mostrar esta página");
  }

  private function get_result_from_db( $common_job_id )
  {
    $common_job = DB::table('common_jobs')->
    select('*')->where('common_jobs.id','=', $common_job_id)->first();
    $ret["all_input"] = (array) $common_job;
    $show_result = new ShowResult();
    $ret["result"] = $show_result->calculate_result((array) $common_job);
    //print_r($ret);      //Bandera
    return $ret;
  }
}
