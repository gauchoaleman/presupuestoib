<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class MakeBudget extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     $min_width = 216;
     $min_height = 128;

     public function __invoke(Request $request)
     {
       if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]== true )
         return $this->proc($request);
       else
         return show_page_without_menubars("no_access");
     }

     private function form_complete()
     {
       //print_r($_POST);
       if( isset($_POST["paper_type_id"]) && isset($_POST["paper_color_id"]) && isset($_POST["weight"]) &&
       $_POST["paper_type_id"] && $_POST["paper_color_id"] && $_POST["weight"] ){
        //print("true");
        return TRUE;
        }
       else{
          //print("false");
          return FALSE;
        }
     }

     private function calculate_size($paper_width,$paper_height,$job_width,$job_height)
     {
       for( $sheet_width_qty=2;$sheet_width_qty<=8;$sheet_width_qty++ ){
         for( $sheet_height_qty=2;$sheet_height_qty<=8;$sheet_height_qty++ ){
           $sheet_width = $paper_width/$sheet_width_qty;
           $sheet_height = $paper_height/$sheet_height_qty;
           if( $sheet_width<$job_width || $sheet_height<$job_height || $sheet_width<$this->min_width || $sheet_height<$this->min_height )
            continue;
           $width_rest = $sheet_width%$job_width;
           $height_rest = $sheet_height%$job_height;
           $width_qty = floor($sheet_width/$job_width);
           $height_qty = floor($sheet_height/$job_height);
           $total_rest = $width_rest*$height_rest+$width_qty*$job_width*$height_rest+$height_qty*$job_height*$width_rest;
           $res["width_qty"] = $width_qty;
           $res["height_qty"] = $height_qty;
           $res["sheet_width"] = $sheet_width;
           $res["sheet_height"] = $sheet_height;
           $res["sheet_width_qty"] = $sheet_width_qty;
           $res["sheet_height_qty"] = $sheet_height_qty;
           $res["rest"] = $total_rest;
           $ret[] = $res;
         }
       }

     }

     private function calculate_budget($paper_type_id, $paper_color_id, $weight, $width, $height)
     {
        $sizes_result = $users = DB::table('paper_prices')->select('height', 'width')->
        where('paper_type_id', '=', $paper_type_id)->
        where('paper_color_id', '=', $paper_color_id)->
        where('weight', '=', $weight)->
        where('paper_prices_set_id', '=', get_latest_paper_price_set_id())->
        get();
        print_r($sizes_result);
        $real_width = $width+5+5;     //Adding width borders
        $real_height = $height+18+8;    //Addding height borders
        foreach ($sizes_result as $size) {
          $normal = calculate_size($size["width"],$size["height"],$real_width,$real_height);    //calculate normal
          $lying = calculate_size($size["width"],$size["height"],$real_height,$real_width);    //calculate lying
        }
     }

     private function proc(Request $request)
     {
       if( $this->form_complete() ) {
         $messages = [
           'width.required' => 'Debe ingresar un ancho.',
           'width.numeric' => 'El ancho debe ser numérico (punto no coma)',
           'height.required' => 'Debe ingresar un alto.',
           'height.numeric' => 'El alto debe ser numérico (punto no coma)',
           ];
         $v = Validator::make($request->all(), [
             'width' => 'required|numeric',
             'height' => 'required|numeric'],
             $messages);

        if ($v->fails())
         return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        else{
          $result = $this->calculate_budget($_POST["paper_type_id"], $_POST["paper_color_id"], $_POST["weight"], $_POST["height"], $_POST["width"] );
          return show_page_with_menubars("budget/make/result");
         }
       }
       else
         return show_page_with_menubars("budget/make/form");
     }

}
