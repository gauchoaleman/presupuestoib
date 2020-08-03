<?php

namespace App\Http\Controllers\Budget\View\Common;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class Listing extends Controller
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

  public function proc($request)
  {
    return $this->show_page_with_menubars("budget/view/common/listing");
  }
}
