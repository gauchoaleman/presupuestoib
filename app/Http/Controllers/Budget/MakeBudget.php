<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class MakeBudget extends Controller
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
         return show_page_without_menubars("no_access");
     }

     private function form_complete()
     {
       //print_r($_POST);
       if( isset($_POST["paper_type_id"]) && isset($_POST["paper_color_id"]) && isset($_POST["weight"]) &&
       $_POST["paper_type_id"] && $_POST["paper_color_id"] && $_POST["weight"] ){
        //print("true");
        return TRUE;
        }
       else{
          //print("false");
          return FALSE;
        }
     }

     private function proc(Request $request)
     {
       if( $this->form_complete() ) {
         $messages = [
           'width.required' => 'Debe ingresar un ancho.',
           'width.numeric' => 'El ancho debe ser numérico (punto no coma)',
           'height.required' => 'Debe ingresar un alto.',
           'height.numeric' => 'El alto debe ser numérico (punto no coma)',
           ];
         $v = Validator::make($request->all(), [
             'width' => 'required|numeric',
             'height' => 'required|numeric'],
             $messages);

         if ($v->fails())
         {
           //return Redirect::back()->withInput(Input::all());
           return redirect()->back()->withInput($request->input())->withErrors($v->errors());
         }

         return show_page_with_menubars("budget/make/result");
       }
       else
         return show_page_with_menubars("budget/make/form");
     }

}
