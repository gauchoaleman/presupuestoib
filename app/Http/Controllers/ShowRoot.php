<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowRoot extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true )
      return $this->show_page_with_menubars("home_page",$message = "");
    else
      return $this->show_page_without_menubars("no_access",$message = "");
  }
}
