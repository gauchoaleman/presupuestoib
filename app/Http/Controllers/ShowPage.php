<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowPage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        echo \Request::url()."<br>";
        echo url()->current()."<br>";
        echo url()->full()."<br>";
        echo \Route::current()->getName()."<br>";
        echo "Req path".$request->path();
    }
}
