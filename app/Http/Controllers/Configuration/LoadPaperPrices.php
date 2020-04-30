<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoadPaperPrices extends Controller
{
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
        return show_page_without_menubars("no_access");
    }

    private function get_new_paper_set_id()
    {

    }
    
    private function proc(Request $request)
    {
      if( isset($_POST["_token"]) ) {
        $filename = time().'.'.$request->file->extension();
        $request->file->move(public_path("uploads/paper_files"), $filename);
        $csv_file = fopen("uploads/paper_files/".$filename,"r");
        $header_row = fgetcsv($csv_file,10000,",",'"'); //Loading header row
        print_r($header_row);
        $row = 1;
        $paper_set_id = $this->get_new_paper_set_id();
        while (($data = fgetcsv($csv_file,10000,",",'"')) !== FALSE) {

          $count = count($data);
          echo "<p> $count de campos en la línea $row: <br /></p>\n";
          $row++;
          for ($c=0; $c < $count; $c++) {
            echo $data[$c] . "<br />\n";
          }

        }

        return show_page_with_menubars("home_page","Precios cargados.");
      }
      else
        return show_page_with_menubars("configuration/load_paper_prices/form");
    }
}
