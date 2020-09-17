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

  private function get_mounting_price($total_pages,$mounting)
  {
    return $total_pages*$this->mounting_per_page_prices[$mounting];
  }

  private function get_finishing_price($copy_qty,$finishing)
  {
    return $copy_qty*$this->finishing_per_copy_prices[$finishing];
  }

  private function get_paper_info($unique_paper,$copy_qty)
  {
    extract($unique_paper);
    extract($paper_data);
    $pose_qty = $pose_width_qty*$pose_height_qty;
    $copy_qty_and_excess = $copy_qty+$this->excess_leaves*$pose_qty;
    $foil_qty = sizeof($foil_list);
    $set_qty = ceil($foil_qty/$pose_qty);
    $rest_foils = $foil_qty%$pose_qty;
    //Last set maybe has half copies
    $total_copies_and_excess = 0;
    if( $set_qty )
      $total_copies_and_excess += ($copy_qty + $this->excess_leaves*$pose_qty)*($set_qty - 1);
    if( $rest_foils )
      $total_copies_and_excess += $copy_qty/$rest_foils + $this->excess_leaves*$pose_qty/$rest_foils;     //Danger, watch this
    $sheet_size = $this->get_sheet_size($paper_price_id);
    $sheet_qty_and_excess = $this->get_sheet_qty($total_copies_and_excess,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty);
    $leaf_qty_and_excess = $this->get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty);

    $data["sheet_size"] = $sheet_size;
    $data["sheet_qty_and_excess"] = $sheet_qty_and_excess;
    $data["leaf_qty_and_excess"] = $leaf_qty_and_excess;
    $data["paper_price"] = $this->get_paper_price($total_copies_and_excess,$paper_price_id,$leaf_width_qty,$leaf_height_qty,$pose_width_qty,$pose_height_qty);
    $data["guillotine_price"] = $this->get_guillotine_price($total_copies_and_excess,$pose_qty);
    //$data["printing_and_plate_info"] = $this->get_printing_and_plate_info($leaf_qty_and_excess,$leaf_width,$leaf_height,$machine,$front_color_qty,$back_color_qty,$front_back);
    //$data["ink_prices"] = $this->get_ink_price($leaf_qty_and_excess,$leaf_width,$leaf_height,$front_color_qty,$back_color_qty,$front_pantone,$back_pantone);
    //$data["total"] = $data["paper_price"]+$data["guillotine_price"]+$data["printing_and_plate_info"]["total"]+$data["ink_prices"]["total"];

    return $data;
  }

  public function calculate_result($result_input)
  {
    print_r($result_input);     //Bandera
    extract($result_input);
    $ret = array();
    $total = 0;

    foreach( $unique_papers as $unique_paper )
      $data["paper_info"][] = $this->get_paper_info($unique_paper,$copy_qty);

    if( $machine_washing_qty ){
      $data["washing_machine_price"] = $this->get_washing_machine_price($machine_washing_qty);
      $total += $data["washing_machine_price"];
    }

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
    print_r($data);     //Bandera
    return $data;

  }
}
?>
