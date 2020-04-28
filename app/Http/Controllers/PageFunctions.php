<?php

class show_page_with_menubars($uri,$message = "") {
  $ret = "";
  $ret .= view('includes/head');
  $ret .= view('includes/top_bar');
  $ret .= $message;
  $ret .= view($uri);
  $ret .= view('includes/bottom_bar');
  $ret .= view('includes/bottom');
  return $ret;
}

function show_page_without_menubars($uri,$message = "") {
  $ret = "";
  $ret .= view('includes/head');
  $ret .= $message;
  $ret .= view($uri);
  $ret .= view('includes/bottom');
  return $ret;
}
?>
