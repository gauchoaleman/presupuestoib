<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

$defaultTimeZone='America/Argentina/Buenos_Aires';
if(date_default_timezone_get()!=$defaultTimeZone)
  date_default_timezone_set($defaultTimeZone);

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show_page_with_menubars($uri,$message = "",$data=array()) {
      $ret = "";
      $ret .= view('includes/head');
      $ret .= view('includes/top_bar');
      if( $message )
        $ret .= $message."<br>";
      $ret .= view($uri,$data);
      $ret .= view('includes/bottom_bar');
      $ret .= view('includes/bottom');
      return $ret;
    }

    public function show_page_without_menubars($uri,$message = "",$data=array()) {
      $ret = "";
      $ret .= view('includes/head');
      if( $message )
        $ret .= $message."<br>";
      $ret .= view($uri,$data);
      $ret .= view('includes/bottom');
      return $ret;
    }

     public $min_sizes = array("Adast"=>array("width"=>520,"height"=>370),
                                "GTO52"=>array("width"=>216,"height"=>128),
                                "GTO46"=>array("width"=>190,"height"=>128));

     public $max_sizes = array("Adast"=>array("width"=>650,"height"=>475),
                                "GTO52"=>array("width"=>510,"height"=>360),
                                "GTO46"=>array("width"=>460,"height"=>325));

     public $price_qty = 1000;

     public $guillotine_price = 123;

     public $folding_price = 123;

     public $punching_arrangement_prices = array(1=>10,2=>20,3=>30,4=>40);
     public $punching_per_qty_prices = array(1=>10,2=>20,3=>30,4=>40);

     public $perforating_arrangement_price = 123;
     public $perforating_per_qty_price = 123;

     public $lac_arrangement_price = 123;
     public $lac_per_qty_price = 123;

     public $min_width = 216;
     public $min_height = 128;

     public $width_borders = 5+5;
     public $height_borders = 15+5;

     public function get_guillotine_price($copy_qty,$pose_qty)
     {
       return $this->guillotine_price*$copy_qty/$this->price_qty;
     }

     public function get_folding_price($copy_qty,$fold_qty)
     {
       return $this->folding_price*($copy_qty/$this->price_qty)*$fold_qty;
     }

     public function get_punching_arrangement_price($difficulty)
     {
       return $this->punching_arrangement_prices[$difficulty];
     }

     public function get_punching_per_qty_price($copy_qty,$difficulty)
     {
       return $this->punching_arrangement_prices[$difficulty]*($copy_qty/$this->price_qty);
     }

     public function get_perforating_arrangement_price()
     {
       return $this->perforating_arrangement_price;
     }

     public function get_perforating_per_qty_price($copy_qty)
     {
       return $this->perforating_per_qty_price*($copy_qty/$this->price_qty);
     }

     public function get_lac_arrangement_price()
     {
       return $this->lac_arrangement_price;
     }

     public function get_lac_per_qty_price($copy_qty)
     {
       return $this->lac_per_qty_price*($copy_qty/$this->price_qty);
     }



     public function calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$pose_qty,$machine,$position,$front_back)
     {
       $ret = array();
       for( $sheet_width_qty=2;$sheet_width_qty<=8;$sheet_width_qty++ ){
         for( $sheet_height_qty=2;$sheet_height_qty<=8;$sheet_height_qty++ ){
           $continue = array(); //Bandera
           //This is the sheet cut out of the big ream
           $sheet_width = floor($paper_width/$sheet_width_qty);
           $sheet_height = floor($paper_height/$sheet_height_qty);


           //To calculate, we take out the borders
           $sheet_width_without_borders = $sheet_width - $this->width_borders;
           $sheet_height_without_borders = $sheet_height - $this->height_borders;

           //If job is greater than sheet we continue
           if( $sheet_width_without_borders<$job_width || $sheet_height_without_borders<$job_height )
            $continue[] = "Job greater than sheet";   //Bandera
            //continue;

           //If sheet is littler than min sheet size we continue
           if( $sheet_width<$this->min_sizes[$machine]["width"] || $sheet_height<$this->min_sizes[$machine]["height"] )
            $continue[] = "Sheet littler than min sheet";   //Bandera
            //continue;

            //If sheet is bigger than max sheet size we continue
            if( $sheet_width>$this->max_sizes[$machine]["width"] || $sheet_height>$this->max_sizes[$machine]["height"] )
             $continue[] = "Sheet bigger than max sheet";   //Bandera
             //continue;

           //Calculate how many times the job fits in the sheet
           $width_qty = floor($sheet_width_without_borders/$job_width);
           $height_qty = floor($sheet_height_without_borders/$job_height);

           if( $front_back == "front_back_width" ){
             if( $width_qty*2*$height_qty < $pose_qty )
              $continue[] = "Pose Qty doesn't match";   //Bandera
            //continue;
           }
           else if( $front_back == "front_back_height" ){
             if( $width_qty*$height_qty*2 < $pose_qty )
              $continue[] = "Pose Qty doesn't match";   //Bandera
            //continue;
           }
           //If there fits no job (width_qty / height_qty equal cero) we continue
           if( $width_qty == 0 || $height_qty == 0 )
            $continue[] = "Job doesn't fit in sheet";   //Bandera
            //continue;
           //Calculate the measure of the aligned jobs
           $all_aligned_job_width = $width_qty*$job_width;
           $all_aligned_job_height = $height_qty*$job_height;

           //Add the borders to the aligned jobs
           $all_aligned_job_width_with_borders = $all_aligned_job_width + $this->width_borders;
           $all_aligned_job_height_with_borders = $all_aligned_job_height + $this->height_borders;

           //if borders is greater than rest we continue
           /*if( $this->width_borders>$simple_width_rest || $this->height_borders>$simple_height_rest )
            $continue[] = "Borders greater than rest";    //Bandera*/
            //continue;

           //Calculate the rest and substracting borders
           $width_rest = $sheet_width_without_borders%$job_width;
           $height_rest = $sheet_height_without_borders%$job_height;
           //Add the rests together
           $total_rest = $width_rest*$height_rest+$all_aligned_job_width*$height_rest+$all_aligned_job_width*$width_rest;

           if( $all_aligned_job_width_with_borders>$sheet_width ||  $all_aligned_job_height_with_borders>$sheet_height)     //If job borders don't fit in sheet
            $continue[] = "Job borders don't fit in sheet";   //Bandera
            //continue;
           $res["paper_price_id"] = $paper_price_id;
           $res["paper_width"] = $paper_width;
           $res["paper_height"] = $paper_height;

           $res["sheet_width_qty"] = $sheet_width_qty;
           $res["sheet_height_qty"] = $sheet_height_qty;

           $res["sheet_width"] = $sheet_width;
           $res["sheet_height"] = $sheet_height;

           $res["job_width"] = $job_width;
           $res["job_height"] = $job_height;

           $res["sheet_width_without_borders"] = $sheet_width_without_borders;
           $res["sheet_height_without_borders"] = $sheet_height_without_borders;

           $res["width_qty"] = $width_qty;
           $res["height_qty"] = $height_qty;

           $res["width_rest"] = $width_rest;      //Bandera
           $res["height_rest"] = $height_rest;    //Bandera
           $res["rest"] = $total_rest;

           $res["position"] = $position;

           $res["front_back"] = $front_back;
           $res["continue"] = $continue;
           $ret[] = $res;
         }
       }
       return $ret;
     }

     public function calculate_size($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$front_color_qty,$back_color_qty,$pose_qty,$machine)
     {
       if( !$back_color_qty ) { //If there is no printing on back ew calculate normal positions
         $normal_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$pose_qty,$machine,"normal","normal");
         $lying_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height,$job_width,$pose_qty,$machine,"lying","normal");
         $merged = array_merge($normal_normal,$lying_normal);
       }
       else { //If there is printing on back we use front and back positions
         $normal_front_back_width = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width*2,$job_height,$pose_qty,$machine,"normal","front_back_width");
         $normal_front_back_height = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height*2,$pose_qty,$machine,"normal","front_back_height");
         $lying_front_back_width = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height*2,$job_width,$pose_qty,$machine,"lying","front_back_width");
         $lying_front_back_height = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height,$job_width*2,$pose_qty,$machine,"lying","front_back_height");
         $merged = array_merge($normal_front_back_width,$normal_front_back_height,$lying_front_back_width,$lying_front_back_height);
         //If no accepted sheet size, we use no front_back
         if( !sizeof($merged) ){
           $normal_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$pose_qty,$machine,"normal","normal");
           $lying_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height,$job_width,$pose_qty,$machine,"lying","normal");
           $merged = array_merge($normal_normal,$lying_normal);
         }
       }
       aasort($merged,"rest");
       //print_r($merged);  //Bandera
       return $merged;
     }



}
