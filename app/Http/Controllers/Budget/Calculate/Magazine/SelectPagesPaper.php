<?php

namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SelectPagesPaper extends Controller
{
  private function form_complete()
  {
    if( isset($_POST["_token"]) ){
      return TRUE;
    }
    else
      return FALSE;
  }

  public function __invoke(Request $request)
  {
    if( $this->form_complete() ){
      $messages = [
      ];
      $v = Validator::make($request->all(),[],
        $messages
      );

      if ($v->fails())
        return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      else
        return $this->show_page_with_menubars("budget/calculate/magazine/select_pages_paper","");
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/select_pages_paper");
  }
}
