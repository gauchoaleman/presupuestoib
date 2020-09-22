<?php

namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Calculation\Magazine\MagazineCalculation;

class ShowResult extends Controller
{
  public function extract_paper_data( $paper_data )
  {
    $extracted_paper_data = explode("/", $paper_data);
    //print_r($paper_data);    //Bandera
    $ret["paper_price_id"] = $extracted_paper_data[0];
    $ret["leaf_width"] = $extracted_paper_data[1];
    $ret["leaf_height"] = $extracted_paper_data[2];
    $ret["leaf_width_qty"] = $extracted_paper_data[3];
    $ret["leaf_height_qty"] = $extracted_paper_data[4];
    $ret["pose_width_qty"] = $extracted_paper_data[5];
    $ret["pose_height_qty"] = $extracted_paper_data[6];
    $ret["position"] = $extracted_paper_data[7];
    $ret["front_back"] = $extracted_paper_data[8];
    return $ret;
  }

  public function add_paper_data_to_unique_papers_with_sizes( $unique_papers_with_sizes,$paper_data )
  {
    foreach( $unique_papers_with_sizes as $unique_paper_key => $unique_paper_with_sizes )
      $unique_papers_with_sizes[$unique_paper_key]["paper_data"] = $paper_data[$unique_paper_key];
    return $unique_papers_with_sizes;
  }

  public function extract_paper_data_from_unique_papers_with_sizes( $unique_papers_with_sizes )
  {
    foreach( $unique_papers_with_sizes as $unique_paper_key => $unique_paper_with_sizes )
      $unique_papers_with_sizes[$unique_paper_key]["paper_data"] = $this->extract_paper_data( $unique_paper_with_sizes["paper_data"] );
    return $unique_papers_with_sizes;
  }

  public function del_sizes_from_unique_papers_with_sizes($unique_papers_with_sizes)
  {
    foreach( $unique_papers_with_sizes as $unique_paper_key => $unique_paper_with_sizes )
      unset($unique_papers_with_sizes[$unique_paper_key]["sizes"]);
    return $unique_papers_with_sizes;
  }

  public function get_result_from_post( $input )
  {
    $magazine_calculation = new MagazineCalculation();

    $unique_papers_with_sizes = unserialize($_POST["unique_papers_with_sizes_serialized"]);
    $unique_papers_with_sizes = $this->add_paper_data_to_unique_papers_with_sizes($unique_papers_with_sizes,$input["paper_data"]);
    $unique_papers_with_sizes = $this->extract_paper_data_from_unique_papers_with_sizes($unique_papers_with_sizes);
    $unique_papers = $this->del_sizes_from_unique_papers_with_sizes($unique_papers_with_sizes);
    $input["shipping"] = pesos_to_dollars($input["shipping"]);
    $input["unique_papers"] = $unique_papers;
    unset($input["unique_papers_with_sizes_serialized"]);
    //unset($input["paper_data"]);
    unset($input["_token"]);
    //$all_input = array_merge($input,$paper_data_input);
    $ret["all_input"] = $input;
    $ret["result"] = $magazine_calculation->calculate_result($input);
    //print_r($input);      //Bandera
    return $ret;
  }

  public function save_budget_to_database($data)
  {

  }
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $data = $this->get_result_from_post($_POST);
    //print("_POST:");       //Bandera
    //print_r($_POST);      //Bandera
    if( $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/calculate/magazine/show_job_paper","",$data);
    else if( $_POST["button_action"] == "show_result" ){
      $this->save_budget_to_database($_POST);
      return $this->show_page_with_menubars("budget/calculate/magazine/show_result","",$data);
    }
  }
}
