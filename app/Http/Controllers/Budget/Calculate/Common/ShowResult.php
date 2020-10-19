<?php

namespace App\Http\Controllers\Budget\Calculate\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Classes\Calculation\Common\CommonCalculation;

class ShowResult extends Controller
{
  public function extract_paper_data( $paper_data )
  {
    $extracted_paper_data = explode("/", $paper_data);
    //print_r($paper_data);    //Bandera
    $ret["paper_price_id"] = $extracted_paper_data[0];
    $ret["leaf_width"] = $extracted_paper_data[1];
    $ret["leaf_height"] = $extracted_paper_data[2];
    $ret["leaf_qty_per_sheet"] = $extracted_paper_data[3];
    $ret["pose_width_qty"] = $extracted_paper_data[4];
    $ret["pose_height_qty"] = $extracted_paper_data[5];
    $ret["position"] = $extracted_paper_data[6];
    $ret["front_back"] = $extracted_paper_data[7];
    return $ret;
  }

  public function get_result_from_post( $input )
  {
    $common_calculation = new CommonCalculation();
    $paper_data_input = $this->extract_paper_data($input["paper_data"]);

    $input["various_finishing"] = pesos_to_dollars($input["various_finishing"]);
    $input["mounting"] = pesos_to_dollars($input["mounting"]);
    $input["shipping"] = pesos_to_dollars($input["shipping"]);

    $all_input = array_merge($input,$paper_data_input);
    $ret["all_input"] = $all_input;
    $ret["result"] = $common_calculation->calculate_result($all_input);

    return $ret;
  }

  public function save_budget_to_database($data)
  {
    print("Input for database:");   //Bandera
    print_r($data);   //Bandera

    $paper_data_input = $this->extract_paper_data($data["paper_data"]);             //Contains: paper_price_id, leaf_width, leaf_height, leaf_qty_per_sheet,        added
                                                                                    //leaf_height_qty, pose_width_qty, pose_height_qty, position, front_back    added
    print("Paper Data input for database:");   //Bandera
    print_r($paper_data_input);   //Bandera
    $data_input["pose_width"] = $data["pose_width"];                                //Checked, added
    $data_input["pose_height"] = $data["pose_height"];                              //Checked, added
    $data_input["copy_qty"] = $data["copy_qty"];                                    //Checked, added
    $data_input["front_machine"] = $data["front_machine"];                                      //Checked, added
    $data_input["back_machine"] = $data["back_machine"];                                      //Checked, added
    $data_input["front_color_qty"] = $data["front_color_qty"];                      //Checked, added
    $data_input["back_color_qty"] = $data["back_color_qty"];                        //Checked, added
    if($data["machine_washing_qty"]) $data_input["machine_washing_qty"] = $data["machine_washing_qty"];     //Checked, added
    if($data["pantone_1"]) $data_input["pantone_1"] = $data["pantone_1"];                                  //Checked, added
    if($data["pantone_2"]) $data_input["pantone_2"] = $data["pantone_2"];                                  //Checked, added
    if($data["pantone_3"]) $data_input["pantone_3"] = $data["pantone_3"];
    if($data["pose_qty"])$data_input["pose_qty"] = $data["pose_qty"];
    if($data["punching_difficulty"])$data_input["punching_difficulty"] = $data["punching_difficulty"];
    if($data["fold_qty"])$data_input["fold_qty"] = $data["fold_qty"];

    $data_input["perforate"] = $data["perforate"]?true:false;                                  //Checked, added
    $data_input["tracing"] = $data["tracing"]?true:false;                                      //Checked, added
    $data_input["lac"] = $data["lac"]?true:false;                                              //Checked, added
    $data_input["compile"] = $data["compile"]?true:false;
    $data_input["various_finishing"] = pesos_to_dollars($data["various_finishing"]);//Checked, added
    $data_input["mounting"] = pesos_to_dollars($data["mounting"]);                  //Checked, added
    $data_input["shipping"] = pesos_to_dollars($data["shipping"]);                  //Checked, added
    $data_input["discount_percentage"] = $data["discount_percentage"]?$data["discount_percentage"]:0;              //Checked, added
    $data_input["plus_percentage"] = $data["plus_percentage"]?$data["plus_percentage"]:0;                      //Checked, added
    $data_input["client_id"] = $data["client_id"];                                  //Checked, added
    $data_input["budget_name"] = $data["budget_name"];                              //Checked, added
    $data_input["dollar_price_id"] = get_actual_dollar_price_id();                         //Checked, added
    $data_input["created_at"] = date('Y-m-d H:i:s');
    $insert_array = array_merge($data_input,$paper_data_input);
    print("Insert array:");     //Bandera
    print_r($insert_array);     //Bandera

    DB::table('common_jobs')->insert($insert_array);
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
      return $this->show_page_without_menubars("budget/calculate/common/show_job_paper","",$data);
    else if( $_POST["button_action"] == "show_result" ){
      $this->save_budget_to_database($_POST);
      return $this->show_page_with_menubars("budget/calculate/common/show_result","",$data);
    }
  }
}
