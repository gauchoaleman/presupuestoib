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

    $data["pose_width_qty"] = $pose_width_qty;
    $data["pose_height_qty"] = $pose_height_qty;
    $data["sheet_size"] = $sheet_size;
    $data["sheet_qty_and_excess"] = $sheet_qty_and_excess;
    $data["leaf_qty_and_excess"] = $leaf_qty_and_excess;
    $data["paper_price"] = $this->get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty,$front_back);
    $data["guillotine_price"] = $this->get_guillotine_price($copy_qty_and_excess,$pose_qty);
    $data["printing_and_plate_info"] = $this->get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$machine,$front_color_qty,$back_color_qty,$front_back);
    $total = $data["paper_price"]+$data["guillotine_price"]+$data["printing_and_plate_info"]["total"];

    if( $fold_qty ){
      $data["fold"] = true;
      $data["folding_arrangement_price"] = $this->get_folding_arrangement_price($fold_qty);
      $data["folding_per_qty_price"] = $this->get_folding_per_qty_price($copy_qty_and_excess,$fold_qty);
      $total += $data["folding_arrangement_price"];
      $total += $data["folding_per_qty_price"];
    }
    else
    $data["fold"] = false;

    if( $punching_difficulty ){
      $data["punch"] = true;
      $data["punching_arrangement_price"] = $this->get_punching_arrangement_price($punching_difficulty);
      $data["punching_per_qty_price"] = $this->get_punching_per_qty_price($copy_qty_and_excess,$punching_difficulty);
      $total += $data["punching_arrangement_price"]+$data["punching_per_qty_price"];
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

    if( $lac ){
      $data["lac"] = true;
      $data["lac_arrangement_price"] = $this->get_lac_arrangement_price();
      $data["lac_per_qty_price"] = $this->get_lac_per_qty_price($copy_qty_and_excess);
      $total += $data["lac_arrangement_price"]+$data["lac_per_qty_price"];
    }
    else
    $data["lac"] = false;

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
    $paper_price_id = $paper_data[0];
    $leaf_width = $paper_data[1];
    $leaf_height = $paper_data[2];
    $leaf_width_qty = $paper_data[3];
    $leaf_height_qty = $paper_data[4];
    $pose_width_qty = $paper_data[5];
    $pose_height_qty = $paper_data[6];
    $position = $paper_data[7];
    $front_back = $paper_data[8];

    $data["copy_qty"] = $input["copy_qty"];
    $data["machine"] = $input["machine"];
    $data["front_color_qty"] = $input["front_color_qty"];
    $data["back_color_qty"] = $input["back_color_qty"];
    $data["fold_qty"] = $input["fold_qty"];
    $data["punching_difficulty"] = $input["punching_difficulty"];
    $data["perforate"] = isset($input["perforate"])?$input["perforate"]:0;
    $data["lac"] = isset($input["lac"])?$input["lac"]:0;
    $data["discount_percentage"] = isset($input["discount_percentage"])?$input["discount_percentage"]:0;
    $data["plus_percentage"] = isset($input["plus_percentage"])?$input["plus_percentage"]:0;

    $data["paper_price_id"] = $paper_price_id;
    $data["leaf_width"] = $leaf_width;
    $data["leaf_height"] = $leaf_height;
    $data["leaf_width_qty"] = $leaf_width_qty;
    $data["leaf_height_qty"] = $leaf_height_qty;
    $data["pose_width_qty"] = $pose_width_qty;
    $data["pose_height_qty"] = $pose_height_qty;
    $data["position"] = $position;
    $data["front_back"] = $front_back;

    $data["client_id"] = $input["client_id"];
    $data["budget_name"] = $input["budget_name"];
    $calculated_result = $this->calculate_result($data);

    return array_merge($data,$calculated_result);
  }

  private function save_budget_to_database($data)
  {
    //print_r($data);
    $insert["paper_price_id"] = $data["paper_price_id"];
    $insert["client_id"] = $data["client_id"];
    $insert["budget_name"] = $data["budget_name"];
    $insert["leaf_width_qty"] = $data["leaf_width_qty"];
    $insert["leaf_height_qty"] = $data["leaf_height_qty"];
    $insert["pose_width_qty"] = $data["pose_width_qty"];
    $insert["pose_height_qty"] = $data["pose_height_qty"];
    $insert["leaf_width"] = $data["leaf_width"];
    $insert["leaf_height"] = $data["leaf_height"];
    $insert["copy_qty"] = $data["copy_qty"];
    $insert["machine"] = $data["machine"];
    $insert["front_color_qty"] = $data["front_color_qty"];
    $insert["back_color_qty"] = $data["back_color_qty"];
    $insert["fold_qty"] = $data["fold_qty"];
    $insert["punching_difficulty"] = $data["punching_difficulty"];
    $insert["perforate"] = $data["perforate"];
    $insert["lac"] = $data["lac"];
    $insert["discount_percentage"] = $data["discount_percentage"];
    $insert["plus_percentage"] = $data["plus_percentage"];
    $insert["position"] = $data["position"];
    $insert["front_back"] = $data["front_back"];
    $insert["dollar_price_id"] = get_dollar_price_id();
  }

  public function proc(Request $request)
  {
    $data = $this->get_result_from_post($_POST);
    //print_r($data);      //Bandera
    if( $_POST["button_action"] == "show_job_paper" )
      return $this->show_page_without_menubars("budget/calculate/common/show_job_paper","",$data);
    else if( $_POST["button_action"] == "show_result" ){
      $this->save_budget_to_database($data);
      return $this->show_page_with_menubars("budget/calculate/common/show_result","",$data);
    }
  }
}
