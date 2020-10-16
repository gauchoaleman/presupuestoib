<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowLeafSizes extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_GET["leaf_sizes_set_id"]))
      return $this->show_page_with_menubars("configuration/show_leaf_sizes/leaf_sizes_list");
    else
      return $this->show_page_with_menubars("configuration/show_leaf_sizes/set_list");
  }
}
