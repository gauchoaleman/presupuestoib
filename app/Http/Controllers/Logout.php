<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Logout extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    $_SESSION["logged_in"] = false;
    return $this->show_page_without_menubars("login_form",$message = "Se deslogueó del sistema.");
  }
}
