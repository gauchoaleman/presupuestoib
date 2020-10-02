<?php

namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
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
      $unique_papers_with_sizes[$unique_paper_key] = array_merge($unique_papers_with_sizes[$unique_paper_key],
                                                                 $this->extract_paper_data( $unique_paper_with_sizes["paper_data"]));
    return $unique_papers_with_sizes;
  }

  public function del_sizes_from_unique_papers_with_sizes($unique_papers_with_sizes)
  {
    foreach( $unique_papers_with_sizes as $unique_paper_key => $unique_paper_with_sizes )
      unset($unique_papers_with_sizes[$unique_paper_key]["sizes"]);
    return $unique_papers_with_sizes;
  }

  public function proc_unique_papers_serialized($unique_papers_with_sizes_serialized,$paper_data)
  {
    $unique_papers_with_sizes = unserialize($unique_papers_with_sizes_serialized);
    $unique_papers_with_sizes = $this->add_paper_data_to_unique_papers_with_sizes($unique_papers_with_sizes,$paper_data);
    $unique_papers_with_sizes = $this->extract_paper_data_from_unique_papers_with_sizes($unique_papers_with_sizes);
    $unique_papers = $this->del_sizes_from_unique_papers_with_sizes($unique_papers_with_sizes);
    return $unique_papers;
  }

  public function get_result_from_post( $input )
  {
    $magazine_calculation = new MagazineCalculation();

    $input["shipping"] = pesos_to_dollars($input["shipping"]);
    $input["unique_papers"] = $this->proc_unique_papers_serialized($input["unique_papers_with_sizes_serialized"],$input["paper_data"]);
    //unset($input["unique_papers_with_sizes_serialized"]);
    //unset($input["paper_data"]);
    unset($input["_token"]);
    //$all_input = array_merge($input,$paper_data_input);
    $ret["all_input"] = $input;
    $ret["result"] = $magazine_calculation->calculate_result($input);
    //print_r($input);      //Bandera
    return $ret;
  }

  public function save_basic_data_to_database($data)
  {
    $data_input["pose_width"] = $data["pose_width"];
    $data_input["pose_height"] = $data["pose_height"];
    $data_input["copy_qty"] = $data["copy_qty"];
    $data_input["page_qty"] = $data["page_qty"];
    if($data["machine_washing_qty"]) $data_input["machine_washing_qty"] = $data["machine_washing_qty"];
    $data_input["finishing"] = $data["finishing"];
    $data_input["mounting"] = $data["mounting"];
    $data_input["shipping"] = pesos_to_dollars($data["shipping"]);
    $data_input["discount_percentage"] = $data["discount_percentage"]?$data["discount_percentage"]:0;
    $data_input["plus_percentage"] = $data["plus_percentage"]?$data["plus_percentage"]:0;
    $data_input["client_id"] = $data["client_id"];
    $data_input["budget_name"] = $data["budget_name"];
    $data_input["dollar_price_id"] = get_actual_dollar_price_id();
    $data_input["created_at"] = date('Y-m-d H:i:s');
    print("Insert array:");     //Bandera
    print_r($data_input);     //Bandera

    DB::table('magazine_jobs')->insert($data_input);
    return DB::getPdo()->lastInsertId();
  }

  public function save_foil_number_to_database($foil_number,$magazine_job_id,$magazine_unique_paper_id)
  {
    $data_input["magazine_job_id"] = $magazine_job_id;
    $data_input["magazine_unique_paper_id"] = $magazine_unique_paper_id;
    $data_input["foil_number"] = $foil_number;
    $data_input["created_at"] = date('Y-m-d H:i:s');
    DB::table('magazine_foil_numbers')->insert($data_input);
  }

  public function save_foil_list($foil_list,$magazine_job_id,$magazine_unique_paper_id)
  {
    foreach($foil_list as $foil_number)
      $this->save_foil_number_to_database($foil_number,$magazine_job_id,$magazine_unique_paper_id);
  }

  public function save_unique_paper_to_database($unique_paper,$magazine_job_id)
  {
    print("Unique paper for database:");    //Bandera
    print_r($unique_paper);                 //Bandera
    $data_input["magazine_job_id"] = $magazine_job_id;
    $data_input["paper_price_id"] = $unique_paper["paper_price_id"];
    $data_input["leaf_width"] = $unique_paper["leaf_width"];
    $data_input["leaf_height"] = $unique_paper["leaf_height"];
    $data_input["leaf_width_qty"] = $unique_paper["leaf_width_qty"];
    $data_input["leaf_height_qty"] = $unique_paper["leaf_height_qty"];
    $data_input["pose_width_qty"] = $unique_paper["pose_width_qty"];
    $data_input["pose_height_qty"] = $unique_paper["pose_height_qty"];
    $data_input["position"] = $unique_paper["position"];
    $data_input["front_back"] = $unique_paper["front_back"];
    $data_input["front_machine"] = $unique_paper["front_machine"];
    $data_input["back_machine"] = $unique_paper["back_machine"];
    $data_input["front_color_qty"] = $unique_paper["front_color_qty"];
    $data_input["back_color_qty"] = $unique_paper["back_color_qty"];
    if(isset($unique_paper["front_pantone"])) $data_input["front_pantone"] = $unique_paper["front_pantone"];
    if(isset($unique_paper["back_pantone"])) $data_input["back_pantone"] = $unique_paper["back_pantone"];
    $data_input["created_at"] = date('Y-m-d H:i:s');

    DB::table('magazine_unique_papers')->insert($data_input);
    $this->save_foil_list($unique_paper["foil_list"],$magazine_job_id,DB::getPdo()->lastInsertId());
  }

  public function save_unique_papers_to_database($unique_papers,$magazine_job_id)
  {
    print("Input for unique papers save to database:");   //Bandera
    print_r($unique_papers);   //Bandera

    foreach($unique_papers as $unique_paper)
      $this->save_unique_paper_to_database($unique_paper,$magazine_job_id);
  }

  public function save_budget_to_database($data)
  {
    $magazine_job_id = $this->save_basic_data_to_database($data);
    $this->save_unique_papers_to_database($this->proc_unique_papers_serialized($data["unique_papers_with_sizes_serialized"],$data["paper_data"]),$magazine_job_id);
  }
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    print("_POST:");       //Bandera
    print_r($_POST);      //Bandera
    $data = $this->get_result_from_post($_POST);
    print_r($data);

    if( $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/calculate/magazine/show_job_paper","",$data);
    else if( $_POST["button_action"] == "show_result" ){
      $this->save_budget_to_database($_POST);
      return $this->show_page_with_menubars("budget/calculate/magazine/show_result","",$data);
    }
  }
}
