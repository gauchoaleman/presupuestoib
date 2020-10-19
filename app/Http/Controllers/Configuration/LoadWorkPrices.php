<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LoadWorkPrices extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function __invoke(Request $request)
  {
    if( isset($_POST["_token"]) ) {
      $filename = time().'.'.$request->file->extension();
      $request->file->move(public_path("uploads/work_prices"), $filename);
      $csv_file = fopen("uploads/work_prices/".$filename,"r"); // For production
      $header_row = fgetcsv($csv_file,10000,",",'"'); //Loading header row
      if( !$this->check_header_row($header_row) )
        return $this->show_page_with_menubars("configuration/load_work_prices/form","Archivo cargado inválido");
      $work_prices_set_id = $this->get_new_work_prices_set_id();
      for ($row = 1;($data = fgetcsv($csv_file,10000,",",'"'))   !== FALSE;$row++) {
        $count = count($data);
        $this->save_work_price_row($work_prices_set_id,$data);
      }
      return $this->show_page_with_menubars("home_page","Precios cargados.");
    }
    else
      return $this->show_page_with_menubars("configuration/load_work_prices/form");
  }

  private function get_new_work_prices_set_id()
  {
    $id = DB::table('work_prices_sets')->insertGetId(array("created_at"=>date('Y-m-d H:i:s')));
    return $id;
  }

  private function save_work_price_row($work_prices_set_id,$work_price_data)
  {
    print_r($work_price_data);      //Bandera
    $insert_array["work_prices_set_id"] = $work_prices_set_id;

    $insert_array["name"] = $work_price_data[0]; //goes in mm
    $insert_array["price"] = str_replace(',', '.',$work_price_data[1]); //goes in mm

    DB::table('work_prices')->insert($insert_array);
  }

  //Validates if file is valid csv with correct header row
  private function check_header_row($header_row)
  {
    return !sizeof(array_diff($header_row,array("nombre","precio")));
  }
}
