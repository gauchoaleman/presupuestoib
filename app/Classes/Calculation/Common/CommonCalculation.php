<?php
namespace App\Classes\Calculation\Common;
use App\Classes\Calculation\Calculation as Calculation;
use DB;

class CommonCalculation extends Calculation
{
  public function get_sheet_qty($copy_qty_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty)
  {
    $sheet_qty = ceil($copy_qty_and_excess/($leaf_width_qty*$leaf_height_qty*$pose_width_qty*$pose_height_qty));
    return $sheet_qty;
  }

  public function get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty)
  {
    $leaf_qty = ceil($copy_qty_and_excess/($pose_width_qty*$pose_height_qty));
    return $leaf_qty;
  }

  public function get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty,$front_back)
  {
    $paper_price_get = DB::table('paper_prices')->
    select('paper_prices.sheet_price')->
    where('paper_prices.id','=', $paper_price_id)->
    first();

    $sheet_price = $paper_price_get->sheet_price;
    $paper_price = $sheet_price*$this->get_sheet_qty($copy_qty_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty);

    return $paper_price;
  }

  public function get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$machine,$front_color_qty,$back_color_qty,$front_back)
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

  public function calculate_result($result_input)
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

    if( $machine_washing_qty ){
      $data["washing_machine_price"] = $this->get_washing_machine_price($machine_washing_qty);
      $total += $data["washing_machine_price"];
    }

    if( $fold_qty ){
      $data["folding"]["arrangement_price"] = $this->get_folding_arrangement_price($fold_qty);
      $data["folding"]["per_qty_price"] = $this->get_folding_per_qty_price($copy_qty_and_excess,$fold_qty);
      $total += $data["folding"]["arrangement_price"]+$data["folding"]["per_qty_price"];
    }

    if( $punching_difficulty ){
      $data["punching"]["arrangement_price"] = $this->get_punching_arrangement_price($punching_difficulty);
      $data["punching"]["per_qty_price"] = $this->get_punching_per_qty_price($copy_qty_and_excess,$punching_difficulty);
      $data["punching"]["break_out_per_qty_price"] = $this->get_break_out_per_qty_price($copy_qty_and_excess);
      $total += $data["punching"]["arrangement_price"]+$data["punching"]["per_qty_price"]+$data["punching"]["break_out_per_qty_price"];
    }

    if( $perforate ){
      $data["perforating"]["arrangement_price"] = $this->get_perforating_arrangement_price();
      $data["perforating"]["per_qty_price"] = $this->get_perforating_per_qty_price($copy_qty_and_excess);
      $total += $data["perforating"]["arrangement_price"]+$data["perforating"]["per_qty_price"];
    }

    if( $tracing ){
      $data["tracing"]["arrangement_price"] = $this->get_tracing_arrangement_price();
      $data["tracing"]["per_qty_price"] = $this->get_tracing_per_qty_price($copy_qty_and_excess);
      $total += $data["tracing"]["arrangement_price"]+$data["tracing"]["per_qty_price"];
    }

    if( $lac ){
      $data["lac"]["arrangement_price"] = $this->get_lac_arrangement_price();
      $data["lac"]["per_qty_price"] = $this->get_lac_per_qty_price($copy_qty_and_excess);
      $total += $data["lac"]["arrangement_price"]+$data["lac"]["per_qty_price"];
    }

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
}
?>
