<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\Page;

class ShowPage extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,$id = "")
    {
      return $this->show_page_with_menubars($request->path(),$message = "");
    }
}
