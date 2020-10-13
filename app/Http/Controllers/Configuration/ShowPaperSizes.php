<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowPaperSizes extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_GET["paper_sizes_set_id"]))
      return $this->show_page_with_menubars("configuration/show_paper_sizes/paper_sizes_list");
    else
      return $this->show_page_with_menubars("configuration/show_paper_sizes/set_list");
  }
}
