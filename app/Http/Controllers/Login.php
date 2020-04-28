<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
$pass_user = "b";
$password = "b";

//require_once "Controllers/PageFunctions.php";
require(app_path() . '/Functions/PageFunctions.php');


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
      if( isset($_SESSION["logged_in"]) )
        return show_page_with_menubars("home_page","Ya estás logueado.");
      elseif( isset($_POST["name"])){
        if( $_POST["name"] == $pass_user && $_POST["password"] == $password ) {
          $_SESSION["logged_in"] = true;
          return show_page_with_menubars("home_page","Login exitoso.");
        }
        else
          return show_page_without_menubars("login_form","Login erróneo.");
      }
      else {
        session_start();
        return show_page_without_menubars("login_form");
      }
    }

}
