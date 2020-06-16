<?php

namespace App\Http\Controllers\Budget\Calculate\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

     public function proc(Request $request)
     {
       print_r($_POST);
       $paper_data = explode("/", $_POST["paper_data"]);
       print_r($paper_data);
       $paper_price_id = $paper_data[0];
       $sheet_width_qty = $paper_data[1];
       $sheet_height_qty = $paper_data[2];
       $width_qty = $paper_data[3];
       $height_qty = $paper_data[4];
       $position = $paper_data[5];
       $front_back = $paper_data[6];
     }
}
