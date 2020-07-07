<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class AddClient extends Controller
{

  private function proc($request)
  {
    if( isset($_POST["_token"]) ) {
      $messages = [
        'name.required' => 'Debe ingresar un nombre.',
      ];
      $v = Validator::make($request->all(), [
        'name' => 'required'],
        $messages
      );

      if ($v->fails())
          return redirect()->back()->withErrors($v->errors());

      DB::table('clients')->insert(array('name' => $_POST['name'],"created_at"=>date('Y-m-d H:i:s')));
      return $this->show_page_with_menubars("home_page","Cliente agregado.");
    }
    else
      return $this->show_page_with_menubars("configuration/add_client/form");
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
      return $this->show_page_without_menubars("no_access");
  }
}
