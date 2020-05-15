<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

$defaultTimeZone='America/Argentina/Buenos_Aires';
if(date_default_timezone_get()!=$defaultTimeZone)
  date_default_timezone_set($defaultTimeZone);

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show_page_with_menubars($uri,$message = "") {
      $ret = "";
      $ret .= view('includes/head');
      $ret .= view('includes/top_bar');
      if( $message )
        $ret .= $message."<br>";
      $ret .= view($uri);
      $ret .= view('includes/bottom_bar');
      $ret .= view('includes/bottom');
      return $ret;
    }

    public function show_page_without_menubars($uri,$message = "") {
      $ret = "";
      $ret .= view('includes/head');
      if( $message )
        $ret .= $message."<br>";
      $ret .= view($uri);
      $ret .= view('includes/bottom');
      return $ret;
    }

}
