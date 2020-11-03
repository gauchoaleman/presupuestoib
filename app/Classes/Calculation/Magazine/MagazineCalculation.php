<?php
namespace App\Classes\Calculation\Magazine;
use App\Classes\Calculation\Calculation as Calculation;
use DB;

class MagazineCalculation extends Calculation
{
  public $finishing_array = array("Gramp"=>"Abrochar","Bind"=>"Encuadernar","Ring"=>"Anillar");
  public $mounting_array = array("Easy"=>"Fácil","Complicated"=>"Complicado");
  public $mounting_per_page_prices = array("Easy"=>123,
                                           "Complicated"=>234);
  public $finishing_per_copy_prices = array("Gramp"=>10,
                                            "Bind"=>20,
                                            "Ring"=>30);

  public function __construct()
  {
     parent::__construct();
  }

  private function get_mounting_price($total_pages,$mounting)
  {
    return $total_pages*$this->mounting_per_page_prices[$mounting];
  }

  private function get_finishing_price($copy_qty,$finishing)
  {
    return $copy_qty*$this->finishing_per_copy_prices[$finishing];
  }

  private function get_totals_from_paper_infos($paper_infos)
  {
    $totals_sum = 0;
    foreach ($paper_infos as $paper_info) {
      $totals_sum += $paper_info["total"];
    }
    return $totals_sum;
  }

  public function get_ink_price($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_color_qty,$back_color_qty,$front_pantone,$back_pantone)
  {
    $pantone_color_qty = $front_pantone+$back_pantone;
    $cmyk_color_qty = $front_color_qty+$back_color_qty-$pantone_color_qty;
    //print("pantone_color_qty:".$pantone_color_qty);     //Bandera
    //print("cmyk_color_qty:".$cmyk_color_qty);        //Bandera
    $ret["cmyk"] = $cmyk_color_qty*($leaf_width/1000)*($leaf_height/1000)*$leaf_qty_and_excess*0.005*$this->cmyk_ink_kilo_price;
    $ret["pantone"] = $pantone_color_qty*($leaf_width/1000)*($leaf_height/1000)*$leaf_qty_and_excess*0.005*$this->pantone_ink_kilo_price;
    $ret["total"] = $ret["cmyk"] + $ret["pantone"];
    return $ret;
  }

  /*Here i calculate
    Printing qty for each foil side
    Printing Arrangement prices
    Printing prices
    Plate qty for each foil side
    Plate prices for each foil side
    */
  public function get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_machine,$back_machine,$front_color_qty,$back_color_qty)
  {
    $total = 0;
    if( $front_machine == $back_machine){
      $printing["qty"][$front_machine] = $leaf_qty_and_excess*($front_color_qty+$back_color_qty);
      $printing["printing_prices"][$front_machine] = $printing["qty"][$front_machine]*$this->printing_prices[$front_machine]/$this->price_qty;
      $printing["arrangement_prices"][$front_machine] = ($front_color_qty+$back_color_qty)*$this->printing_arrangement_prices[$front_machine];
      $plate["qty"][$front_machine] = $front_color_qty+$back_color_qty;
      $plate["prices"][$front_machine] = $plate["qty"][$front_machine]*$this->plate_prices[$front_machine];
      $total += $printing["printing_prices"][$front_machine]+$plate["prices"][$front_machine]+$printing["arrangement_prices"][$front_machine];
    }
    else{
      $printing["qty"][$front_machine] = $leaf_qty_and_excess*$front_color_qty;
      $printing["printing_prices"][$front_machine] = $printing["qty"][$front_machine]*$this->printing_prices[$front_machine]/$this->price_qty;
      $printing["arrangement_prices"][$front_machine] = $front_color_qty*$this->printing_arrangement_prices[$front_machine];
      $plate["qty"][$front_machine] = $front_color_qty;
      $plate["prices"][$front_machine] = $plate["qty"][$front_machine]*$this->plate_prices[$front_machine];
      $total += $printing["printing_prices"][$front_machine]+$plate["prices"][$front_machine]+$printing["arrangement_prices"][$front_machine];

      if( $back_machine ){
        $printing["qty"][$back_machine] = $leaf_qty_and_excess*$back_color_qty;
        $printing["printing_prices"][$back_machine] = $printing["qty"][$back_machine]*$this->printing_prices[$back_machine]/$this->price_qty;
        $printing["arrangement_prices"][$back_machine] = $back_color_qty*$this->printing_arrangement_prices[$back_machine];
        $plate["qty"][$back_machine] = $back_color_qty;
        $plate["prices"][$back_machine] = $plate["qty"][$back_machine]*$this->plate_prices[$back_machine];
        $total += $printing["printing_prices"][$back_machine]+$plate["prices"][$back_machine]+$printing["arrangement_prices"][$back_machine];
      }
    }
    $ret["printing"] = $printing;
    $ret["plate"] = $plate;
    $ret["total"] = $total;
    return $ret;
  }
  // Get prices for each paper set
  private function get_paper_info($unique_paper,$copy_qty)
  {
    //print("Unique paper at paper_info:");
    //print_r($unique_paper);     //Bandera
    extract($unique_paper);
    //extract($paper_data);
    $pose_qty = $pose_width_qty*$pose_height_qty;
    //$copy_qty_and_excess = $copy_qty+$this->excess_leaves*$pose_qty;
    $foil_qty = sizeof($foil_list);
    $set_qty = ceil($foil_qty/$pose_qty);
    $rest_foils = $foil_qty%$pose_qty;
    //Last set maybe has half copies
    $total_copies_and_excess = 0;
    //If there are no rest_foils I have full sets
    if( $set_qty && !$rest_foils )
      $total_copies_and_excess += ($copy_qty + $this->excess_leaves*$pose_qty)*$set_qty;
    //If there is rest_foils the last set is not complete
    else if( $set_qty )
      $total_copies_and_excess += ($copy_qty + $this->excess_leaves*$pose_qty)*($set_qty-1);
    //Here I calculate the rest_foils
    if( $rest_foils )
      $total_copies_and_excess += $copy_qty/$rest_foils + $this->excess_leaves*$pose_qty/$rest_foils;     //Danger, watch this
    $sheet_size = $this->get_sheet_size($paper_price_id);
    $sheet_qty_and_excess = $this->get_sheet_qty($total_copies_and_excess,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty);
    $leaf_qty_and_excess = $this->get_leaf_qty($total_copies_and_excess,$pose_width_qty,$pose_height_qty);

    $data["sheet_size"] = $sheet_size;
    $data["total_copies_and_excess"] = $total_copies_and_excess;
    $data["sheet_qty_and_excess"] = $sheet_qty_and_excess;
    $data["leaf_qty_and_excess"] = $leaf_qty_and_excess;
    $data["pose_qty"] = $pose_qty;
    $data["copy_qty"] = $copy_qty;
    $data["set_qty"] = $set_qty;
    $data["rest_foils"] = $rest_foils;
    $data["foil_qty"] = $foil_qty;

    $data["paper_price"] = $this->get_paper_price($total_copies_and_excess,$paper_price_id,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty);
    $data["guillotine_price"] = $this->get_guillotine_price($total_copies_and_excess,$pose_qty);
    $data["printing_and_plate_info"] = $this->get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_machine,$back_machine,
    $front_color_qty,$back_color_qty);
    if( !isset($front_pantone) )
      $front_pantone = 0;
      if( !isset($back_pantone) )
        $back_pantone = 0;
    $data["ink_prices"] = $this->get_ink_price($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_color_qty,$back_color_qty,$front_pantone,$back_pantone);
    $data["total"] = $data["paper_price"]+$data["guillotine_price"]+$data["printing_and_plate_info"]["total"]+$data["ink_prices"]["total"];
    return $data;
  }

  //Here I call root prices and call get_paper_info for each paper set
  public function calculate_result($result_input)
  {
    //print_r($result_input);     //Bandera
    extract($result_input);
    $ret = array();
    $data = array();
    $total = 0;

    foreach( $unique_papers as $unique_paper )
      $data["paper_info"][] = $this->get_paper_info($unique_paper,$copy_qty);

    $total += $this->get_totals_from_paper_infos($data["paper_info"]);

    if( $machine_washing_qty ){
      $data["washing_machine_price"] = $this->get_washing_machine_price($machine_washing_qty);
      $total += $data["washing_machine_price"];
    }

    $foil_qty = ($page_qty+4)/4;
    $total_foils_and_excess = $foil_qty*($copy_qty+$this->excess_leaves);
    $data["compile"] = $this->get_compile_per_qty_price($total_foils_and_excess);
    $total += $data["compile"];

    $data["mounting"] = $this->get_mounting_price($page_qty+4,$mounting);
    $total += $data["mounting"];

    $data["finishing"] = $this->get_finishing_price($copy_qty,$finishing);
    $total += $data["finishing"];

    $total += $shipping;

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
    //print("Result data:");      //Bandera
    //print_r($data);     //Bandera
    return $data;

  }
}
?>
