<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowPaperPrices extends Controller
{
  private function proc($request)
  {
    if( isset($_GET["paper_prices_set_id"]))
      return show_page_with_menubars("configuration/show_paper_prices/paper_prices_list");
    else
      return show_page_with_menubars("configuration/show_paper_prices/set_list");
  }
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
      return $this->show_page_without_menubars("no_access");
  }
}
