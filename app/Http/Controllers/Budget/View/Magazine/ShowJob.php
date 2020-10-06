<?php

namespace App\Http\Controllers\Budget\View\Magazine;

use App\Http\Controllers\Controller;
use App\Classes\Calculation\Magazine\MagazineCalculation;
use Illuminate\Http\Request;
use DB;

class ShowJob extends Controller
{
  private function get_foil_list_from_db($magazine_unique_paper_id,$magazine_job_id)
  {
    $foil_numbers_result = DB::table('magazine_foil_numbers')->select('magazine_foil_numbers.foil_number')->
                                  where([
                                    ['magazine_job_id','=', $magazine_job_id],
                                    ['magazine_unique_paper_id','=', $magazine_unique_paper_id]])->
                                  get();
    $ret = array();

    foreach($foil_numbers_result as $foil_number_tuple )
      $ret[] = $foil_number_tuple->foil_number;

    print("foil_numbers_ret");    //Bandera
    print_r($ret);    //Bandera
    return $ret;
  }

  private function get_magazine_unique_papers_from_db($magazine_job_id)
  {
    $unique_papers = DB::table('magazine_unique_papers')->
    join('paper_prices', 'magazine_unique_papers.paper_price_id', '=', 'paper_prices.id')->
    select('magazine_unique_papers.*','paper_prices.paper_type_id','paper_prices.paper_color_id','paper_prices.weight')->where('magazine_job_id','=', $magazine_job_id)->get();
    print("unique papers in get_magazine_unique_papers_from_db");      //Bandera
    print_r($unique_papers);     //Bandera
    $unique_papers_ret = array();
    foreach($unique_papers as $unique_paper_array_position => $unique_paper){
      $unique_papers_ret[$unique_paper_array_position] = (array) $unique_paper;
      $unique_papers_ret[$unique_paper_array_position]["foil_list"] = $this->get_foil_list_from_db($unique_papers_ret[$unique_paper_array_position]["id"],$magazine_job_id);
    }
    return $unique_papers_ret;
  }

  private function get_magazine_basic_data_from_db($magazine_job_id)
  {
    return (array) DB::table('magazine_jobs')->select('magazine_jobs.*')->where('magazine_jobs.id','=', $magazine_job_id)->first();
  }

  private function get_result_from_db( $magazine_job_id,$actual_dollar )
  {

    $ret["all_input"] = $this->get_magazine_basic_data_from_db($magazine_job_id);
    $magazine_unique_papers = $this->get_magazine_unique_papers_from_db($magazine_job_id);
    $ret["all_input"]["unique_papers"] = $magazine_unique_papers;
    if( $actual_dollar )
      $ret["all_input"]["dollar_price_id"] = get_actual_dollar_price_id();
    $ret["all_input"]["magazine_job_id"] = $magazine_job_id;
    $magazine_calculation = new MagazineCalculation();
    $ret["result"] = $magazine_calculation->calculate_result($ret["all_input"]);
    //print_r($ret);      //Bandera
    return $ret;
  }

  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request,$magazine_job_id)
  {
    if(isset($_GET["actual_dollar"]) )
      $actual_dollar = true;
    else
      $actual_dollar = false;

    $data = $this->get_result_from_db($magazine_job_id,$actual_dollar);
    print("get_result_from_db return");     //Bandera
    print_r($data);
    if( isset($_POST["button_action"]) && $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/view/magazine/show_job_paper","",$data);
    else
      return $this->show_page_with_menubars("budget/view/magazine/show_job","",$data);
  }
}
?>
