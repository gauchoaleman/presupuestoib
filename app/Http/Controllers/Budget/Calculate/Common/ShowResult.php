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

     private function get_sheet_qty($copy_qty,$sheet_width_qty,$sheet_height_qty,$pose_width_qty,$pose_height_qty)
     {
       $sheet_qty = ceil($copy_qty/($sheet_width_qty*$sheet_height_qty*$pose_width_qty*$pose_height_qty));
       return $sheet_qty;
     }

     private function get_leaf_qty($copy_qty,$pose_width_qty,$pose_height_qty)
     {
       $leaf_qty = ceil($copy_qty/($pose_width_qty*$pose_height_qty));
       return $leaf_qty;
     }

     private function get_paper_price($copy_qty,$paper_price_id,$sheet_width_qty,$sheet_height_qty,$pose_width_qty,$pose_height_qty)
     {
       $paper_price_get = DB::table('paper_prices')->
       select('paper_prices.sheet_price')->
       where('paper_prices.id','=', $paper_price_id)->
       first();

       $sheet_price = $paper_price_get->sheet_price;

       return $sheet_price*$this->get_sheet_qty($copy_qty,$sheet_width_qty,$sheet_height_qty,$pose_width_qty,$pose_height_qty);
     }

     private function get_printing_price($sheet_qty,$sheet_width,$sheet_height,$machine,$front_color_qty,$back_color_qty,$front_back)
     {
       if( $machine = "GTO52" ){
         if( $front_back == "front_back_width" || $front_back == "front_back_height"){
           $print_qty["GTO52"] = 2*$sheet_qty*$front_color_qty;
           $plate_qty["GTO52"] = $front_color_qty;
         }
         else{
           if( $back_color_qty <= 2 && fits_size("GTO46",$sheet_width,$sheet_height)){
             $print_qty["GTO46"] = $sheet_qty*$back_color_qty;
             $plate_qty["GTO46"] = $back_color_qty;
           }
           else{
             $print_qty["GTO52"] = $sheet_qty*($front_color_qty+$back_color_qty);
             $plate_qty["GTO52"] = $front_color_qty+$back_color_qty;
           }
         }
       }
       else if( $machine = "GTO46" ){
         $print_qty["GTO46"] = $sheet_qty*($front_color_qty+$back_color_qty);
         $plate_qty["GTO46"] = $front_color_qty+$back_color_qty;
       }
       else if( $machine = "Adast" ){
         $print_qty["Adast"] = $sheet_qty*($front_color_qty+$back_color_qty);
         $plate_qty["Adast"] = $front_color_qty+$back_color_qty;
       }
       $ret["print_qty"] = $print_qty;
       $ret["plate_qty"] = $plate_qty;
       return $ret;
     }

     private function get_plates_price($front_color_qty,$back_color_qty,$front_back)
     {
       return 100;
     }

     public function proc(Request $request)
     {
       //print_r($_POST);   //Bandera
       $paper_data = explode("/", $_POST["paper_data"]);
       //print_r($paper_data);    //Bandera
       $paper_price_id = $paper_data[0];
       $sheet_width_qty = $paper_data[1];
       $sheet_height_qty = $paper_data[2];
       $pose_width_qty = $paper_data[3];
       $pose_height_qty = $paper_data[4];
       $position = $paper_data[5];
       $front_back = $paper_data[6];

       $copy_qty = $_POST["copy_qty"];
       $machine = $_POST["machine"];
       $front_color_qty = $_POST["front_color_qty"];
       $back_color_qty = $_POST["back_color_qty"];
       $fold_qty = $_POST["fold_qty"];
       $punching_difficulty = $_POST["punching_difficulty"];
       $perforate = isset($_POST["perforate"])?$_POST["perforate"]:0;
       $lac = isset($_POST["lac"])?$_POST["lac"]:0;

       $pose_qty = $pose_width_qty*$pose_height_qty;

       $data["sheet_width_qty"] = $sheet_width_qty;
       $data["sheet_height_qty"] = $sheet_height_qty;
       $data["pose_width_qty"] = $pose_width_qty;
       $data["pose_height_qty"] = $pose_height_qty;

       $data["sheet_qty"] = $this->get_sheet_qty($copy_qty,$sheet_width_qty,$sheet_height_qty,$pose_width_qty,$pose_height_qty);
       $data["leaf_qty"] = $this->get_leaf_qty($copy_qty,$pose_width_qty,$pose_height_qty);
       $data["paper_price"] = $this->get_paper_price($copy_qty,$paper_price_id,$sheet_width_qty,$sheet_height_qty,$pose_width_qty,$pose_height_qty);
       $data["guillotine_price"] = $this->get_guillotine_price($copy_qty,$pose_qty);
       $data["printing_price"] = $this->get_printing_price($leaf_qty,$sheet_width,$sheet_height,$machine,$front_color_qty,$back_color_qty,$front_back);
       $data["plates_price"] = $this->get_plates_price($front_color_qty,$back_color_qty,$front_back);
       $total = $data["paper_price"]+$data["guillotine_price"]+$data["printing_price"]+$data["plates_price"];

       if( $fold_qty ){
         $data["fold"] = true;
         $data["folding_arrangement_price"] = $this->get_folding_arrangement_price($fold_qty);
         $data["folding_per_qty_price"] = $this->get_folding_per_qty_price($copy_qty,$fold_qty);
         $total += $data["folding_arrangement_price"];
         $total += $data["folding_per_qty_price"];
       }
       else
         $data["fold"] = false;

       if( $punching_difficulty ){
         $data["punch"] = true;
         $data["punching_arrangement_price"] = $this->get_punching_arrangement_price($punching_difficulty);
         $data["punching_per_qty_price"] = $this->get_punching_per_qty_price($copy_qty,$punching_difficulty);
         $total += $data["punching_arrangement_price"]+$data["punching_per_qty_price"];
       }
       else
         $data["punch"] = false;

       if( $perforate ){
         $data["perforate"] = true;
         $data["perforating_arrangement_price"] = $this->get_perforating_arrangement_price();
         $data["perforating_per_qty_price"] = $this->get_perforating_per_qty_price($copy_qty);
         $total += $data["perforating_arrangement_price"]+$data["perforating_per_qty_price"];
       }
       else
         $data["perforate"] = false;

       if( $lac ){
         $data["lac"] = true;
         $data["lac_arrangement_price"] = $this->get_lac_arrangement_price();
         $data["lac_per_qty_price"] = $this->get_lac_per_qty_price($copy_qty);
         $total += $data["lac_arrangement_price"]+$data["lac_per_qty_price"];
       }
       else
         $data["lac"] = false;

       $data["total"] = $total;
       //print_r($data);      //Bandera
       return $this->show_page_with_menubars("budget/calculate/common/show_result","",$data);
     }
}
