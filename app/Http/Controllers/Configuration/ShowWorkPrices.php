<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowWorkPrices extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_GET["work_prices_set_id"]))
      return $this->show_page_with_menubars("configuration/show_work_prices/work_prices_list");
    else
      return $this->show_page_with_menubars("configuration/show_work_prices/set_list");
  }
}
