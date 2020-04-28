<?php

public function show_page_with_menubars() {
  $ret = "";
  $ret .= view('includes/head');
  $ret .= view('includes/top_bar');
  if( $this->message )
    $ret .= $message;
  $ret .= view($this->uri);
  $ret .= view('includes/bottom_bar');
  $ret .= view('includes/bottom');
  return $ret;
}

public function show_page_without_menubars($uri,$message = "") {
  $ret = "";
  $ret .= view('includes/head');
  $ret .= $message;
  $ret .= view($uri);
  $ret .= view('includes/bottom');
  return $ret;
}

?>
