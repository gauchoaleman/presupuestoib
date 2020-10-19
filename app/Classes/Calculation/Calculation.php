<?php
namespace App\Classes\Calculation;
use DB;

class Calculation
{
  public $continue_if_invalid_size = false;

  public $machine_list = array("Adast","GTO52","GTO46");

  public $min_sizes = array("Adast"=>array("width"=>210,"height"=>120),
                            "GTO52"=>array("width"=>216,"height"=>128),
                            "GTO46"=>array("width"=>190,"height"=>128));

  public $max_sizes = array("Adast"=>array("width"=>650,"height"=>475),
                            "GTO52"=>array("width"=>510,"height"=>360),
                            "GTO46"=>array("width"=>460,"height"=>325));

  public $price_qty = 1000;

  public $excess_leaves = 100;

  public $machine_washing_price = 5;

  public $printing_prices = array("Adast"=>123,
                                  "GTO52"=>234,
                                  "GTO46"=>345);

  public $printing_arrangement_prices = array("Adast"=>123,
                                              "GTO52"=>234,
                                              "GTO46"=>345);

  public $plate_prices = array("Adast"=>12,
                               "GTO52"=>23,
                               "GTO46"=>34);

  public $cmyk_ink_kilo_price = 10;
  public $pantone_ink_kilo_price = 20;

  public $guillotine_price = 123;

  public $folding_arrangement_price = 123;
  public $folding_per_qty_price = 123;

  public $punching_arrangement_prices = array(1=>10,2=>20,3=>30,4=>40);
  public $punching_per_qty_prices = array(1=>10,2=>20,3=>30,4=>40);
  public $break_out_price = 123;

  public $perforating_arrangement_price = 123;
  public $perforating_per_qty_price = 123;

  public $tracing_arrangement_price = 100;
  public $tracing_per_qty_price = 100;

  public $lac_arrangement_price = 123;
  public $lac_per_qty_price = 123;

  public $compile_per_qty_price = 123;

  public $width_borders = 5+5;
  public $height_borders = 15+5;

  public function get_guillotine_price($copy_qty_and_excess,$pose_qty)
  {
    return $this->guillotine_price*$copy_qty_and_excess/$this->price_qty;
  }

  public function get_washing_machine_price($machine_washing_qty)
  {
    return $this->machine_washing_price*$machine_washing_qty;
  }

  public function get_folding_arrangement_price($fold_qty)
  {
    return $this->folding_arrangement_price*$this->price_qty*$fold_qty;
  }

  public function get_folding_per_qty_price($copy_qty_and_excess,$fold_qty)
  {
    return $this->folding_per_qty_price*($copy_qty_and_excess/$this->price_qty)*$fold_qty;
  }

  public function get_punching_arrangement_price($difficulty)
  {
    return $this->punching_arrangement_prices[$difficulty];
  }

  public function get_punching_per_qty_price($copy_qty_and_excess,$difficulty)
  {
    return $this->punching_arrangement_prices[$difficulty]*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_break_out_per_qty_price($copy_qty_and_excess)
  {
    return $this->break_out_price*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_perforating_arrangement_price()
  {
    return $this->perforating_arrangement_price;
  }

  public function get_perforating_per_qty_price($copy_qty_and_excess)
  {
    return $this->perforating_per_qty_price*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_tracing_arrangement_price()
  {
    return $this->tracing_arrangement_price;
  }

  public function get_tracing_per_qty_price($copy_qty_and_excess)
  {
    return $this->tracing_per_qty_price*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_lac_arrangement_price()
  {
    return $this->lac_arrangement_price;
  }

  public function get_lac_per_qty_price($copy_qty_and_excess)
  {
    return $this->lac_per_qty_price*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_compile_per_qty_price($copy_qty_and_excess)
  {
    return $this->compile_per_qty_price*($copy_qty_and_excess/$this->price_qty);
  }

  public function get_sheet_size($paper_price_id)
  {
    $sheet_size_get = DB::table('paper_prices')->
    select('paper_prices.width','paper_prices.height')->
    where('paper_prices.id','=', $paper_price_id)->
    first();
    $ret["width"] = $sheet_size_get->width;
    $ret["height"] = $sheet_size_get->height;
    return $ret;
  }

  public function fits_size($machine,$leaf_width,$leaf_height)
  {
    echo "max_width ".$machine.":".$this->max_sizes[$machine]["width"]."<br>";
    echo "max_height ".$machine.":".$this->max_sizes[$machine]["height"]."<br>";
    echo "leaf_width:".$leaf_width."<br>";
    echo "leaf_height:".$leaf_height."<br>";
    return $this->max_sizes[$machine]["width"]>=$leaf_width && $this->max_sizes[$machine]["height"]>=$leaf_height;
  }

  public function get_sheet_qty($copy_qty_and_excess,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty)
  {
    $sheet_qty = ceil($copy_qty_and_excess/($leaf_qty_per_sheet*$pose_width_qty*$pose_height_qty));
    return $sheet_qty;
  }

  public function get_leaf_qty($copy_qty_and_excess,$pose_width_qty,$pose_height_qty)
  {
    $leaf_qty = ceil($copy_qty_and_excess/($pose_width_qty*$pose_height_qty));
    return $leaf_qty;
  }

  public function get_paper_price($copy_qty_and_excess,$paper_price_id,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty)
  {
    $paper_price_get = DB::table('paper_prices')->
    select('paper_prices.sheet_price')->
    where('paper_prices.id','=', $paper_price_id)->
    first();

    $sheet_price = $paper_price_get->sheet_price;
    $paper_price = $sheet_price*$this->get_sheet_qty($copy_qty_and_excess,$leaf_qty_per_sheet,$pose_width_qty,$pose_height_qty);

    return $paper_price;
  }

  public function calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,$position,$front_back)
  {
    $ret = array();
    //echo $machine;      //Bandera
    if( $position == "lying" )
      swap($pose_width,$pose_height);

    if( $front_back == "front_back_width" )
      $pose_width *= 2;
    if( $front_back == "front_back_height" )
      $pose_height *= 2;

    $leaf_sizes = DB::table('leaf_sizes')->select('leaf_width','leaf_height','leaf_qty_per_sheet')->
    where('sheet_width', '=', $sheet_width)->
    where('sheet_height', '=', $sheet_height)->
    where('leaf_sizes_set_id', '=', get_latest_leaf_size_set_id())->
    get();

    foreach( $leaf_sizes as $leaf_size ){
      $continue = array(); //Bandera
      //This is the sheet cut out of the big ream
      $leaf_width = $leaf_size->leaf_width;
      $leaf_height = $leaf_size->leaf_height;

      //To calculate, we take out the borders
      $leaf_width_without_borders = $leaf_width - $this->width_borders;
      $leaf_height_without_borders = $leaf_height - $this->height_borders;

      //If job is greater than sheet we continue
      if( $leaf_width_without_borders<$pose_width || $leaf_height_without_borders<$pose_height ){
        if( $this->continue_if_invalid_size )
          continue;
        else
          $continue[] = "Pose greater than sheet";   //Bandera;
      }
        //continue;

       //Calculate how many times the job fits in the sheet
      $pose_width_qty = floor($leaf_width_without_borders/$pose_width);
      $pose_height_qty = floor($leaf_height_without_borders/$pose_height);

      if( $pose_qty ){
        if( $front_back == "front_back_width" ){
          if( $pose_width_qty*2*$pose_height_qty != $pose_qty ){
            if( $this->continue_if_invalid_size )
              continue;
            else
              $continue[] = "Pose Qty doesn't match";   //Bandera;
          }
        }
        else if( $front_back == "front_back_height" ){
          if( $pose_width_qty*$pose_height_qty*2 != $pose_qty ){
            if( $this->continue_if_invalid_size )
              continue;
            else
              $continue[] = "Pose Qty doesn't match";   //Bandera;
          }
        }
        else{
          if( $pose_width_qty*$pose_height_qty != $pose_qty ){
            if( $this->continue_if_invalid_size )
              continue;
            else
              $continue[] = "Pose Qty doesn't match";   //Bandera;
          }
        }
      }
      //If there fits no job (width_qty / height_qty equal cero) we continue
      if( $pose_width_qty == 0 || $pose_height_qty == 0 ){
        if( $this->continue_if_invalid_size )
          continue;
        else
          $continue[] = "Pose doesn't fit in sheet";   //Bandera;
      }
      //Calculate the measure of the aligned jobs
      $all_aligned_pose_width = $pose_width_qty*$pose_width;
      $all_aligned_pose_height = $pose_height_qty*$pose_height;

      //Add the borders to the aligned jobs
      $all_aligned_pose_width_with_borders = $all_aligned_pose_width + $this->width_borders;
      $all_aligned_pose_height_with_borders = $all_aligned_pose_height + $this->height_borders;

       //if borders is greater than rest we continue
       /* if( $this->width_borders>$simple_width_rest || $this->height_borders>$simple_height_rest )
            $continue[] = "Borders greater than rest";    //Bandera*/
        //continue;

      //Calculate the rest and substracting borders
      $width_rest = $leaf_width_without_borders%$pose_width;
      $height_rest = $leaf_height_without_borders%$pose_height;
      //Add the rests together
      $total_rest = $width_rest*$height_rest+$all_aligned_pose_width_with_borders*$height_rest+$all_aligned_pose_height_with_borders*$width_rest;

      //If job borders don't fit in sheet
      if( $all_aligned_pose_width_with_borders>$leaf_width ||  $all_aligned_pose_height_with_borders>$leaf_height){
        if( $this->continue_if_invalid_size )
          continue;
        else
          $continue[] = "Pose borders don't fit in sheet";   //Bandera;
      }

      //If sheet is bigger than max sheet size we continue
      if( $all_aligned_pose_width_with_borders>$this->max_sizes[$front_machine]["width"] ||
          $all_aligned_pose_height_with_borders>$this->max_sizes[$front_machine]["height"] ||
          $all_aligned_pose_width_with_borders>$this->max_sizes[$back_machine]["width"] ||
          $all_aligned_pose_height_with_borders>$this->max_sizes[$back_machine]["height"] ){
        if( $this->continue_if_invalid_size )
          continue;
        else
          $continue[] = "Job bigger than max sheet";   //Bandera;
      }

      //If sheet is littler than min sheet size we continue
      if( $all_aligned_pose_width_with_borders<$this->min_sizes[$front_machine]["width"] ||
          $all_aligned_pose_height_with_borders<$this->min_sizes[$front_machine]["height"] ||
          $all_aligned_pose_width_with_borders<$this->min_sizes[$back_machine]["width"] ||
          $all_aligned_pose_height_with_borders<$this->min_sizes[$back_machine]["height"] ){
        if( $this->continue_if_invalid_size )
          continue;
        else
          $continue[] = "Job littler than min sheet";   //Bandera;
      }


      $res["paper_price_id"] = $paper_price_id;
      $res["sheet_width"] = $sheet_width;
      $res["sheet_height"] = $sheet_height;

      $res["leaf_qty_per_sheet"] = $leaf_size->leaf_qty_per_sheet;

      $res["leaf_width"] = $leaf_width;
      $res["leaf_height"] = $leaf_height;

      $res["pose_width"] = $pose_width;
      $res["pose_height"] = $pose_height;

      $res["leaf_width_without_borders"] = $leaf_width_without_borders;
      $res["leaf_height_without_borders"] = $leaf_height_without_borders;

      $res["pose_width_qty"] = $pose_width_qty;
      $res["pose_height_qty"] = $pose_height_qty;

      $res["width_rest"] = $width_rest;      //Bandera
      $res["height_rest"] = $height_rest;    //Bandera
      $res["rest"] = $total_rest;

      $res["position"] = $position;

      $res["front_back"] = $front_back;
      $res["continue"] = $continue;

      if( $front_back == "front_back_width" ){
        $res["pose_width"] /= 2;
        $res["pose_width_qty"] *= 2;
      }
      if( $front_back == "front_back_height" ){
        $res["pose_height"] /= 2;
        $res["pose_height_qty"] *= 2;
      }

      $ret[] = $res;

    }
    return $ret;
  }

  public function calculate_size($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$front_color_qty,$back_color_qty,$pose_qty,$front_machine,$back_machine,$front_back=true)
  {
    if( !$back_color_qty || !$front_back) { //If there is no printing on back ew calculate normal positions
      $normal_normal = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"normal","normal");
      $lying_normal = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"lying","normal");
      $merged = array_merge($normal_normal,$lying_normal);
    }
    else if($front_back){ //If there is printing on back we use front and back positions
      $normal_front_back_width = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"normal","front_back_width");
      $normal_front_back_height = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"normal","front_back_height");
      $lying_front_back_width = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"lying","front_back_width");
      $lying_front_back_height = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"lying","front_back_height");
      $merged = array_merge($normal_front_back_width,$normal_front_back_height,$lying_front_back_width,$lying_front_back_height);
      //If no accepted sheet size, we use no front_back
      //echo(sizeof($merged)."/");   //Bandera
      //print_r($merged);    //Bandera
      if( !sizeof($merged) ){
          //echo "Banderazo";   //Bandera
          $normal_normal = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"normal","normal");
          $lying_normal = $this->calculate_position($paper_price_id,$sheet_width,$sheet_height,$pose_width,$pose_height,$pose_qty,$front_machine,$back_machine,"lying","normal");
          $merged = array_merge($normal_normal,$lying_normal);
        }
    }
    aasort($merged,"rest");
    //print_r($merged);  //Bandera
    return $merged;
  }
}

?>
