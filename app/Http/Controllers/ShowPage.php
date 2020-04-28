<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\Page;

class ShowPage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,$id = "No id")
    {

      $ret = "";
      $ret .= view('includes/head');
      $ret .= view('includes/top_bar');
      $ret .= "Req path: ".$request->path()."<br>";
      $ret .= "Id: ".$id;
      $ret .= view('includes/bottom_bar');
      $ret .= view('includes/bottom');
      return $ret;
    }
}
