<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
       if( isset($_POST["paper_type"]) && isset($_POST["paper_color"]))
        return true;
       else 
          return false;
     }

     private function proc(Request $request)
     {
       if( $this->form_complete() ) {
         return show_page_with_menubars("budget/make/result");
       }
       else
         return show_page_with_menubars("budget/make/form");
     }

     public function fetch(Request $request)
     {
       $select = $request->get('select');
       $value = $request->get('value');
       $dependent = $request->get('dependent');

       if( $dependent == "color" )
       echo $this->get_colors($value);
       elseif( $dependent == "gramms" )
        echo $this->get_colors($value);

        $data = DB::table('country_state_city')
        ->where($select, $value)
        ->groupBy($dependent)
        ->get();
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($data as $row)
        {
          $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }
}
