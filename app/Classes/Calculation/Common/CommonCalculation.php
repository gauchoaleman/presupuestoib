<?php
namespace App\Classes\Calculation\Common;
use App\Classes\Calculation\Calculation as Calculation;
use DB;

class CommonCalculation extends Calculation
{
  public function get_pantone_color_qty($pantone_1,$pantone_2,$pantone_3)
  {
    $ret = 0;
    $pantone_1?$ret++:assert(true);
    $pantone_2?$ret++:assert(true);
    $pantone_3?$ret++:assert(true);
    return $ret;
  }

  public function get_ink_price($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_color_qty,$back_color_qty,$pantone_1,$pantone_2,$pantone_3)
  {
    $pantone_color_qty = $this->get_pantone_color_qty($pantone_1,$pantone_2,$pantone_3);
    $cmyk_color_qty = $front_color_qty+$back_color_qty-$pantone_color_qty;
    //print("pantone_color_qty:".$pantone_color_qty);     //Bandera
    //print("cmyk_color_qty:".$cmyk_color_qty);        //Bandera
    $ret["cmyk"] = $cmyk_color_qty*($leaf_width/1000)*($leaf_height/1000)*$leaf_qty_and_excess*0.005*$this->cmyk_ink_kilo_price;
    $ret["pantone"] = $pantone_color_qty*($leaf_width/1000)*($leaf_height/1000)*$leaf_qty_and_excess*0.005*$this->pantone_ink_kilo_price;
    $ret["total"] = $ret["cmyk"] + $ret["pantone"];
    return $ret;
  }

  public function get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_machine,$back_machine,$front_color_qty,$back_color_qty,$front_back)
  {
    $total = 0;
      //echo "In GTO46";      //Bandera
    if( $front_machine == $back_machine ){
      $machine = $front_machine;
      $printing["qty"][$machine] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty);
      $printing["printing_prices"][$machine] = $printing["qty"][$machine]*$this->printing_prices[$machine]/$this->price_qty;
      $printing["arrangement_prices"][$machine] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices[$machine];
      $plate["qty"][$machine] = $front_color_qty+$back_color_qty;
      $plate["prices"][$machine] = $plate["qty"][$machine]*$this->plate_prices[$machine];
      $total += $printing["printing_prices"][$machine]+$plate["prices"][$machine]+$printing["arrangement_prices"][$machine];
    }
    else {
      $printing["qty"][$front_machine] = $leaf_qty_and_excess*$front_color_qty;
      $printing["printing_prices"][$front_machine] = $printing["qty"][$front_machine]*$this->printing_prices[$front_machine]/$this->price_qty;
      $printing["arrangement_prices"][$front_machine] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices[$front_machine];
      $plate["qty"][$front_machine] = $front_color_qty;
      $plate["prices"][$front_machine] = $plate["qty"][$front_machine]*$this->plate_prices[$front_machine];
      $total += $printing["printing_prices"][$front_machine]+$plate["prices"][$front_machine]+$printing["arrangement_prices"][$front_machine];

      $printing["qty"][$back_machine] = $leaf_qty_and_excess*$back_color_qty;
      $printing["printing_prices"][$back_machine] = $printing["qty"][$back_machine]*$this->printing_prices[$back_machine]/$this->price_qty;
      $printing["arrangement_prices"][$back_machine] = $back_color_qty*$this->printing_arrangement_prices[$back_machine];
      $plate["qty"][$back_machine] = $back_color_qty;
      $plate["prices"][$back_machine] = $plate["qty"][$back_machine]*$this->plate_prices[$back_machine];
      $total += $printing["printing_prices"][$back_machine]+$plate["prices"][$back_machine]+$printing["arrangement_prices"][$back_machine];
    }

    $ret["printing"] = $printing;
    $ret["plate"] = $plate;
    $ret["total"] = $total;
    return $ret;
  }

  public function calculate_result($result_input)
  {
    extract($result_input);
    //print_r($result_input);       //Bandera

    $pose_qty = $pose_width_qty*$pose_height_qty;
    $copy_qty_and_excess = $copy_qty+$this->excess_leaves*$pose_qty;
    $sheet_qty_and_excess = $this->get_sheet_qty($copy_qty_and_excess,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty);
    $sheet_size = $this->get_sheet_size($paper_price_id);
    $leaf_qty_and_excess = $this->get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty);
    /*
    $data["pose_width_qty"] = $pose_width_qty;
    $data["pose_height_qty"] = $pose_height_qty;
    */
    $data["sheet_size"] = $sheet_size;
    $data["sheet_qty_and_excess"] = $sheet_qty_and_excess;
    $data["leaf_qty_and_excess"] = $leaf_qty_and_excess;
    $data["paper_price"] = $this->get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty);
    $data["guillotine_price"] = $this->get_guillotine_price($copy_qty_and_excess,$pose_qty);
    $data["printing_and_plate_info"] = $this->get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_machine,$back_machine,$front_color_qty,$back_color_qty,$front_back);
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
