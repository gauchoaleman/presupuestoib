<?php
session_start();

function get_dollar_price() {
  $max_dollar_price = DB::table('dollar_prices')->orderBy('id', 'desc')->select('amount')->first();
  return $max_dollar_price->amount;
}

function show_page_with_menubars($uri,$message = "") {
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

function show_page_without_menubars($uri,$message = "") {
  $ret = "";
  $ret .= view('includes/head');
  if( $message )
    $ret .= $message."<br>";
  $ret .= view($uri);
  $ret .= view('includes/bottom');
  return $ret;
}

?>
