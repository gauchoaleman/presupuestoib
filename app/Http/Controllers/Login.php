<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      global $pass_user,$password;
      //phpinfo();
      if( isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]== true )
        return show_page_with_menubars("home_page","Ya estás logueado.");
      elseif( isset($_POST["user"])){
        if( $_POST["user"] == "b" && $_POST["password"] == "b" ) {
          $_SESSION["logged_in"] = true;
          return show_page_with_menubars("home_page","Login exitoso.");
        }
        else
          return show_page_without_menubars("login_form","Login erróneo.");
      }
      else
        return show_page_without_menubars("login_form");
    }

}
