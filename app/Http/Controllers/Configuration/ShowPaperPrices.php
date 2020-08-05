<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowPaperPrices extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_GET["paper_prices_set_id"]))
      return $this->show_page_with_menubars("configuration/show_paper_prices/paper_prices_list");
    else
      return $this->show_page_with_menubars("configuration/show_paper_prices/set_list");
  }
}
