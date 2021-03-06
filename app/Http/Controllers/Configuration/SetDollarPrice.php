<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;



class SetDollarPrice extends Controller
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
    if( isset($_POST["_token"]) ) {

      $messages = [
        'amount.required' => 'Debe ingresar un monto.',
        'amount.numeric' => 'El monto debe ser numérico (punto no coma)',
      ];
      $v = Validator::make($request->all(), [
        'amount' => 'required|numeric'],
        $messages
      );

      if ($v->fails())
          return redirect()->back()->withErrors($v->errors());

      DB::table('dollar_prices')->insert(array('amount' => $_POST['amount'],"created_at"=>date('Y-m-d H:i:s')));
      return $this->show_page_with_menubars("home_page","Precio dólar cargado.");
    }
    else
      return $this->show_page_with_menubars("configuration/set_dollar_price/form");
  }
}
