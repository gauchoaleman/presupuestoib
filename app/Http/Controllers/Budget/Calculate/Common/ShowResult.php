<?php

namespace App\Http\Controllers\Budget\Calculate\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ShowResult extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]== true )
      return $this->proc($request);
    else
      return $this->show_page_without_menubars("no_access");
  }

  private function get_sheet_qty($copy_qty_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty)
  {
    $sheet_qty = ceil($copy_qty_and_excess/($leaf_width_qty*$leaf_height_qty*$pose_width_qty*$pose_height_qty));
    return $sheet_qty;
  }

  private function get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty)
  {
    $leaf_qty = ceil($copy_qty_and_excess/($pose_width_qty*$pose_height_qty));
    return $leaf_qty;
  }

  private function get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty,$front_back)
  {
    $paper_price_get = DB::table('paper_prices')->
    select('paper_prices.sheet_price')->
    where('paper_prices.id','=', $paper_price_id)->
    first();

    $sheet_price = $paper_price_get->sheet_price;
    $paper_price = $sheet_price*$this->get_sheet_qty($copy_qty_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty);

    return $paper_price;
  }

  private function get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$machine,$front_color_qty,$back_color_qty,$front_back)
  {
    $total = 0;
    if( $machine == "GTO52" ){
      //echo "In GTO52";      //Bandera
      if( $front_back == "front_back_width" || $front_back == "front_back_height" ){
        $printing["qty"]["GTO52"] = 2*$leaf_qty_and_excess*$front_color_qty;
        $printing["printing_prices"]["GTO52"] = 2*$leaf_qty_and_excess*$front_color_qty*$this->printing_prices["GTO52"]/$this->price_qty;
        $printing["arrangement_prices"]["GTO52"] = $front_color_qty*$this->printing_arrangement_prices["GTO52"];
        $plate["qty"]["GTO52"] = $front_color_qty;
        $plate["prices"]["GTO52"] = $front_color_qty*$this->plate_prices["GTO52"];
        $total += $printing["printing_prices"]["GTO52"]+$plate["prices"]["GTO52"]+$printing["arrangement_prices"]["GTO52"];
      }
      else{
        //echo "fits_size:".$this->fits_size("GTO46",$leaf_width,$leaf_height);   //Bandera
        if( $back_color_qty <= 2 && $back_color_qty > 0 && $this->fits_size("GTO46",$leaf_width,$leaf_height) ){
          $printing["qty"]["GTO46"] = $leaf_qty_and_excess*$back_color_qty;
          $printing["printing_prices"]["GTO46"] = $leaf_qty_and_excess*$back_color_qty*$this->printing_prices["GTO46"]/$this->price_qty;
          $printing["arrangement_prices"]["GTO46"] = $back_color_qty*$this->printing_arrangement_prices["GTO46"];
          $plate["qty"]["GTO46"] = $back_color_qty;
          $plate["prices"]["GTO46"] = $back_color_qty*$this->plate_prices["GTO46"];
          $total += $printing["printing_prices"]["GTO46"]+$plate["prices"]["GTO46"]+$printing["arrangement_prices"]["GTO46"];

          $printing["qty"]["GTO52"] = $leaf_qty_and_excess*$front_color_qty;
          $printing["printing_prices"]["GTO52"] = $leaf_qty_and_excess*$front_color_qty*$this->printing_prices["GTO52"]/$this->price_qty;
          $printing["arrangement_prices"]["GTO52"] = $front_color_qty*$this->printing_arrangement_prices["GTO52"];
          $plate["qty"]["GTO52"] = $front_color_qty;
          $plate["prices"]["GTO52"] = $front_color_qty*$this->plate_prices["GTO52"];
          $total += $printing["printingprices"]["GTO52"]+$plate["prices"]["GTO52"]+$printing["arrangement_prices"]["GTO52"];
        }
        else{
          $printing["qty"]["GTO52"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty);
          $printing["printing_prices"]["GTO52"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty)*$this->printing_prices["GTO52"]/$this->price_qty;
          $printing["arrangement_prices"]["GTO52"] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices["GTO52"];
          $plate["qty"]["GTO52"] = $front_color_qty+$back_color_qty;
          $plate["prices"]["GTO52"] = ($front_color_qty+$back_color_qty)*$this->plate_prices["GTO52"];
          $total += $printing["printing_prices"]["GTO52"]+$plate["prices"]["GTO52"]+$printing["arrangement_prices"]["GTO52"];
        }
      }
    }
    else if( $machine == "GTO46" ){
      //echo "In GTO46";      //Bandera
      $printing["qty"]["GTO46"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty);
      $printing["printing_prices"]["GTO46"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty)*$this->printing_prices["GTO46"]/$this->price_qty;
      $printing["arrangement_prices"]["GTO46"] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices["GTO46"];
      $plate["qty"]["GTO46"] = $front_color_qty+$back_color_qty;
      $plate["prices"]["GTO46"] = ($front_color_qty+$back_color_qty)*$this->plate_prices["GTO46"];
      $total += $printing["printing_prices"]["GTO46"]+$plate["prices"]["GTO46"]+$printing["arrangement_prices"]["GTO46"];
    }
    else if( $machine == "Adast" ){
      $printing["qty"]["Adast"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty);
      $printing["printing_prices"]["Adast"] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty)*$this->printing_prices["Adast"]/$this->price_qty;
      $printing["arrangement_prices"]["Adast"] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices["GTO52"];
      $plate["qty"]["Adast"] = $front_color_qty+$back_color_qty;
      $plate["prices"]["Adast"] = ($front_color_qty+$back_color_qty)*$this->plate_prices["Adast"];
      $total += $printing["printing_prices"]["Adast"]+$plate["prices"]["Adast"]+$printing["arrangement_prices"]["Adast"];
    }
    $ret["printing"] = $printing;
    $ret["plate"] = $plate;
    $ret["total"] = $total;
    return $ret;
  }

  private function calculate_result($result_input)
  {
    extract($result_input);

    $pose_qty = $pose_width_qty*$pose_height_qty;
    $copy_qty_and_excess = $copy_qty+$this->excess_leaves*$pose_qty;
    $sheet_qty_and_excess = $this->get_sheet_qty($copy_qty_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty);
    $sheet_size = $this->get_sheet_size($paper_price_id);
    $leaf_qty_and_excess = $this->get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty);
    /*
    $data["pose_width_qty"] = $pose_width_qty;
    $data["pose_height_qty"] = $pose_height_qty;
    */
    $data["sheet_size"] = $sheet_size;
    $data["sheet_qty_and_excess"] = $sheet_qty_and_excess;
    $data["leaf_qty_and_excess"] = $leaf_qty_and_excess;
    $data["paper_price"] = $this->get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty,$front_back);
    $data["guillotine_price"] = $this->get_guillotine_price($copy_qty_and_excess,$pose_qty);
    $data["printing_and_plate_info"] = $this->get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$machine,$front_color_qty,$back_color_qty,$front_back);
    $data["ink_prices"] = $this->get_ink_price($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_color_qty,$back_color_qty,$pantone_1,$pantone_2,$pantone_3);
    $total = $data["paper_price"]+$data["guillotine_price"]+$data["printing_and_plate_info"]["total"]+$data["ink_prices"]["total"];

    if( $fold_qty ){
      $data["fold"] = true;
      $data["folding_arrangement_price"] = $this->get_folding_arrangement_price($fold_qty);
      $data["folding_per_qty_price"] = $this->get_folding_per_qty_price($copy_qty_and_excess,$fold_qty);
      $total += $data["folding_arrangement_price"]+$data["folding_per_qty_price"];
    }
    else
      $data["fold"] = false;

    if( $punching_difficulty ){
      $data["punch"] = true;
      $data["punching_arrangement_price"] = $this->get_punching_arrangement_price($punching_difficulty);
      $data["punching_per_qty_price"] = $this->get_punching_per_qty_price($copy_qty_and_excess,$punching_difficulty);
      $data["break_out_per_qty_price"] = $this->get_break_out_per_qty_price($copy_qty_and_excess);
      $total += $data["punching_arrangement_price"]+$data["punching_per_qty_price"]+$data["break_out_per_qty_price"];
    }
    else
    $data["punch"] = false;

    if( $perforate ){
      $data["perforate"] = true;
      $data["perforating_arrangement_price"] = $this->get_perforating_arrangement_price();
      $data["perforating_per_qty_price"] = $this->get_perforating_per_qty_price($copy_qty_and_excess);
      $total += $data["perforating_arrangement_price"]+$data["perforating_per_qty_price"];
    }
    else
    $data["perforate"] = false;

    if( $tracing ){
      $data["tracing"] = true;
      $data["tracing_arrangement_price"] = $this->get_tracing_arrangement_price();
      $data["tracing_per_qty_price"] = $this->get_tracing_per_qty_price($copy_qty_and_excess);
      $total += $data["tracing_arrangement_price"]+$data["tracing_per_qty_price"];
    }
    else
    $data["perforate"] = false;

    if( $lac ){
      $data["lac"] = true;
      $data["lac_arrangement_price"] = $this->get_lac_arrangement_price();
      $data["lac_per_qty_price"] = $this->get_lac_per_qty_price($copy_qty_and_excess);
      $total += $data["lac_arrangement_price"]+$data["lac_per_qty_price"];
    }
    else
    $data["lac"] = false;

    $total += $various_finishing+$mounting+$shipping;

    if( $discount_percentage ){
      $data["subtotal"] = $total;
      $data["discount_price"] = $total*$discount_percentage/100;
      $total -= $total*$discount_percentage/100;
    }
    else if( $plus_percentage ){
      $data["subtotal"] = $total;
      $data["plus_price"] = $total*$plus_percentage/100;
      $total += $total*$plus_percentage/100;
    }
    else
    $data["subtotal"] = false;

    if( isset($dollar_price_id) )
      $data["dollar_price"] = get_dollar_price($dollar_price_id);
    else
      $data["dollar_price"] = get_dollar_price();
    $data["total"] = $total;
    return $data;
  }

  private function get_result_from_post( $input )
  {
    $paper_data = explode("/", $input["paper_data"]);
    //print_r($paper_data);    //Bandera
    $input["paper_price_id"] = $paper_data[0];
    $input["leaf_width"] = $paper_data[1];
    $input["leaf_height"] = $paper_data[2];
    $input["leaf_width_qty"] = $paper_data[3];
    $input["leaf_height_qty"] = $paper_data[4];
    $input["pose_width_qty"] = $paper_data[5];
    $input["pose_height_qty"] = $paper_data[6];
    $input["position"] = $paper_data[7];
    $input["front_back"] = $paper_data[8];

    $input["perforate"] = isset($input["perforate"])?$input["perforate"]:0;
    $input["tracing"] = isset($input["tracing"])?$input["tracing"]:0;
    $input["lac"] = isset($input["lac"])?$input["lac"]:0;

    $input["various_finishing"] = $input["various_finishing"]?$input["various_finishing"]/get_dollar_price():0;
    $input["mounting"] = $input["mounting"]?$input["mounting"]/get_dollar_price():0;
    $input["shipping"] = $input["shipping"]?$input["shipping"]/get_dollar_price():0;
    $input["discount_percentage"] = isset($input["discount_percentage"])?$input["discount_percentage"]:0;
    $input["plus_percentage"] = isset($input["plus_percentage"])?$input["plus_percentage"]:0;

    $calculated_result = $this->calculate_result($input);

    return array_merge($input,$calculated_result);
  }

  private function save_budget_to_database($data)
  {
    print("Input for database:");   //Bandera
    print_r($data);   //Bandera
    $insert_array["paper_price_id"] = $data["paper_price_id"];
    $insert_array["client_id"] = $data["client_id"];
    $insert_array["budget_name"] = $data["budget_name"];
    $insert_array["leaf_width_qty"] = $data["leaf_width_qty"];
    $insert_array["leaf_height_qty"] = $data["leaf_height_qty"];
    $insert_array["pose_width_qty"] = $data["pose_width_qty"];
    $insert_array["pose_height_qty"] = $data["pose_height_qty"];
    $insert_array["leaf_width"] = $data["leaf_width"];
    $insert_array["leaf_height"] = $data["leaf_height"];
    $insert_array["copy_qty"] = $data["copy_qty"];
    $insert_array["machine"] = $data["machine"];
    $insert_array["front_color_qty"] = $data["front_color_qty"];
    $insert_array["back_color_qty"] = $data["back_color_qty"];
    $insert_array["pantone_1"] = $data["pantone_1"];
    $insert_array["pantone_2"] = $data["pantone_2"];
    $insert_array["pantone_3"] = $data["pantone_3"];
    $insert_array["fold_qty"] = $data["fold_qty"];
    $insert_array["punching_difficulty"] = $data["punching_difficulty"];
    $insert_array["perforate"] = $data["perforate"];
    $insert_array["lac"] = $data["lac"];
    $insert_array["various_finishing"] = $data["various_finishing"];
    $insert_array["mounting"] = $data["mounting"];
    $insert_array["shipping"] = $data["shipping"];
    $insert_array["discount_percentage"] = $data["discount_percentage"];
    $insert_array["plus_percentage"] = $data["plus_percentage"];
    $insert_array["position"] = $data["position"];
    $insert_array["front_back"] = $data["front_back"];
    $insert_array["dollar_price_id"] = get_dollar_price_id();
    print("Insert array:");     //Bandera
    print_r($insert_array);     //Bandera
  }

  public function proc(Request $request)
  {
    $data = $this->get_result_from_post($_POST);
    print_r($data);      //Bandera
    if( $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/calculate/common/show_job_paper","",$data);
    else if( $_POST["button_action"] == "show_result" ){
      $this->save_budget_to_database($data);
      return $this->show_page_with_menubars("budget/calculate/common/show_result","",$data);
    }
  }
}
