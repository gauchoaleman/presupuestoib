<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LoadLeafSizes extends Controller
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
      $request->file->move(public_path("uploads/leaf_sizes"), $filename);
      $csv_file = fopen("uploads/leaf_sizes/".$filename,"r"); // For production
      $header_row = fgetcsv($csv_file,10000,",",'"'); //Loading header row
      if( !$this->check_header_row($header_row) )
        return $this->show_page_with_menubars("configuration/load_leaf_sizes/form","Archivo cargado inválido");
      $leaf_sizes_set_id = $this->get_new_leaf_sizes_set_id();
      for ($row = 1;($data = fgetcsv($csv_file,10000,",",'"'))   !== FALSE;$row++) {
        $count = count($data);
        $this->save_leaf_size_row($leaf_sizes_set_id,$data);
      }
      return $this->show_page_with_menubars("home_page","Tamaños cargados.");
    }
    else
      return $this->show_page_with_menubars("configuration/load_leaf_sizes/form");
  }

  private function get_new_leaf_sizes_set_id()
  {
    $id = DB::table('leaf_sizes_sets')->insertGetId(array("created_at"=>date('Y-m-d H:i:s')));
    return $id;
  }

  private function save_leaf_size_row($leaf_sizes_set_id,$leaf_size_data)
  {
    //print_r($leaf_size_data);      //Bandera
    $insert_array["leaf_sizes_set_id"] = $leaf_sizes_set_id;

    $insert_array["sheet_width"] = str_replace(',', '.',$leaf_size_data[0])*10; //goes in mm
    $insert_array["sheet_height"] = str_replace(',', '.',$leaf_size_data[1])*10; //goes in mm
    $insert_array["leaf_width"] = str_replace(',', '.',$leaf_size_data[2])*10; //goes in mm
    $insert_array["leaf_height"] = str_replace(',', '.',$leaf_size_data[3])*10; //goes in mm
    $insert_array["leaf_qty_per_sheet"] = $leaf_size_data[4]; //goes in mm

    DB::table('leaf_sizes')->insert($insert_array);
  }

  //Validates if file is valid csv with correct header row
  private function check_header_row($header_row)
  {
    return !sizeof(array_diff($header_row,array("ancho hoja","alto hoja","ancho pliego","alto pliego","pliegos por hoja")));
  }
}
