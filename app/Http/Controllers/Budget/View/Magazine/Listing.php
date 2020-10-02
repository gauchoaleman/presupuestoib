<?php

namespace App\Http\Controllers\Budget\View\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Listing extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function __invoke(Request $request)
  {
    return $this->show_page_with_menubars("budget/view/magazine/listing");
  }

}
