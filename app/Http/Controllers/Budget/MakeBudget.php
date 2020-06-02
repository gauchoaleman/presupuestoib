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
     private $min_width = 216;
     private $min_height = 128;
     private $width_borders = 5+5;
     private $height_borders = 15+5;

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

     private function calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$position,$front_back)
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
           if( $sheet_width<$this->min_width || $sheet_height<$this->min_height )
            $continue[] = "Sheet littler than min sheet";   //Bandera
            //continue;

           //Calculate how many times the job fits in the sheet
           $width_qty = floor($sheet_width_without_borders/$job_width);
           $height_qty = floor($sheet_height_without_borders/$job_height);

           //If there fits no job (widt_qty / height_qty equal cero) we continue
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


     private function calculate_size($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,$front_color_qty,$back_color_qty)
     {
       if( !$back_color_qty ) { //If there is no printing on back ew calculate normal positions
         $normal_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height,"normal","normal");
         $lying_normal = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height,$job_width,"lying","normal");
         $merged = array_merge($normal_normal,$lying_normal);
       }
       else { //If there is printing on back we use front and back positions
         $normal_front_back_width = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width*2,$job_height,"normal","front_back_width");
         $normal_front_back_height = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_width,$job_height*2,"normal","front_back_height");
         $lying_front_back_width = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height*2,$job_width,"lying","front_back_width");
         $lying_front_back_height = $this->calculate_position($paper_price_id,$paper_width,$paper_height,$job_height,$job_width*2,"lying","front_back_height");
         $merged = array_merge($normal_front_back_width,$normal_front_back_height,$lying_front_back_width,$lying_front_back_height);
       }
       aasort($merged,"rest");
       //print_r($merged);  //Bandera
       return $merged;
     }

     private function calculate_budget($paper_type_id, $paper_color_id, $weight, $width, $height,$front_color_qty,$back_color_qty)
     {
        $sizes_result = DB::table('paper_prices')->select('id','width','height')->
        where('paper_type_id', '=', $paper_type_id)->
        where('paper_color_id', '=', $paper_color_id)->
        where('weight', '=', $weight)->
        where('paper_prices_set_id', '=', get_latest_paper_price_set_id())->
        get();
        //print_r($sizes_result); //Bandera
        $size_res = array();
        $all_sizes = array();
        foreach ($sizes_result as $size) {
          $size_res = $this->calculate_size($size->id,$size->width,$size->height,$width,$height,$front_color_qty,$back_color_qty);    //calculate
          //print($size->width."x".$size->height.": "); //Bandera
          //print_r($size_res); //Bandera
          $all_sizes = array_merge($size_res,$all_sizes);
        }
        aasort($all_sizes,"rest");
        //print_r($all_sizes);    //Bandera
        $ret["all_sizes"] = $all_sizes;
        return $ret;
     }

     private function proc(Request $request)
     {
       if( $this->form_complete() ) {
         $messages = [
           'width.required' => 'Debe ingresar un ancho.',
           'width.integer' => 'El ancho debe ser un entero.',
           'width.gt' => 'El ancho debe ser mayor a cero.',
           'height.required' => 'Debe ingresar un alto.',
           'height.integer' => 'El alto debe ser un entero.',
           'height.gt' => 'El alto debe ser mayor a cero.',
           'front_color_qty.required' => 'Debe ingresar colores de frente.',
           'front_color_qty.integer' => 'La cantidad de colores de frente debe ser un entero.',
           'front_color_qty.gt' => 'La cantidad de colores de frente debe ser mayor a cero.',
           'back_color_qty.integer' => 'La cantidad de colores de dorso debe ser un entero.'
           ];
         $v = Validator::make($request->all(), [
             'width' => 'required|integer|gt:0',
             'height' => 'required|integer|gt:0',
             'front_color_qty' => 'required|integer|gt:0',
             'back_color_qty' => 'integer',],
             $messages);

        if ($v->fails())
         return redirect()->back()->withInput($request->input())->withErrors($v->errors());
        else{
          $result = $this->calculate_budget($_POST["paper_type_id"], $_POST["paper_color_id"], $_POST["weight"], $_POST["height"], $_POST["width"],
          $_POST["front_color_qty"],$_POST["back_color_qty"]);
          $data["result"]=$result;
          return $this->show_page_with_menubars("budget/make/result","",$data);
         }
       }
       else
         return $this->show_page_with_menubars("budget/make/form");
     }

}
