<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowPaperPrices extends Controller
{

    private function proc($request)
    {
      
    }
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
        return show_page_without_menubars("no_access");
        //
    }
}
