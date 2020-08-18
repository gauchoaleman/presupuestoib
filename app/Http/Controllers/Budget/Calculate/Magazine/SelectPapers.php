<?php

namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectPapers extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      print("@SelectPapers"); //Bandera
      print_r($_POST); //Bandera
        //
    }
}
