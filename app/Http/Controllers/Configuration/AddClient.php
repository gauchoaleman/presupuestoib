<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class AddClient extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    return $this->add_client($request);
  }

  public function popup(Request $request)
  {
    return $this->add_client($request,true);
  }

  public function add_client(Request $request,$popup=false)
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
      if( $popup )
        return $this->show_page_without_menubars("configuration/add_client/close_window");
      else
        return $this->show_page_with_menubars("home_page","Cliente agregado.");
    }
    else if( $popup )
      return $this->show_page_without_menubars("configuration/add_client/popup_form");
    else
      return $this->show_page_with_menubars("configuration/add_client/form");
  }
}
