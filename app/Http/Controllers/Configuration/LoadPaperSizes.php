<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class LoadPaperSizes extends Controller
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
      $request->file->move(public_path("uploads/paper_sizes"), $filename);
      $csv_file = fopen("uploads/paper_sizes/".$filename,"r"); // For production
      //$csv_file = fopen("uploads/paper_sizes/test_file.txt","r"); //For testing
      $header_row = fgetcsv($csv_file,10000,",",'"'); //Loading header row
      if( !$this->check_header_row($header_row) )
        return $this->show_page_with_menubars("configuration/load_paper_sizes/form","Archivo cargado inválido");
      $paper_sizes_set_id = $this->get_new_paper_sizes_set_id();
      for ($row = 1;($data = fgetcsv($csv_file,10000,",",'"'))   !== FALSE;$row++) {
        $count = count($data);
        $this->save_paper_size_row($paper_sizes_set_id,$data);
      }
      return $this->show_page_with_menubars("home_page","Tamaños cargados.");
    }
    else
      return $this->show_page_with_menubars("configuration/load_paper_sizes/form");
  }

  private function get_new_paper_sizes_set_id()
  {
    $id = DB::table('paper_sizes_sets')->insertGetId(array("created_at"=>date('Y-m-d H:i:s')));
    return $id;
  }

  private function save_paper_size_row($paper_sizes_set_id,$paper_size_data)
  {
    print_r($paper_size_data);      //Bandera
    $insert_array["paper_sizes_set_id"] = $paper_sizes_set_id;

    $insert_array["sheet_width"] = str_replace(',', '.',$paper_size_data[0])*10; //goes in mm
    $insert_array["sheet_height"] = str_replace(',', '.',$paper_size_data[1])*10; //goes in mm
    $insert_array["leaf_width"] = str_replace(',', '.',$paper_size_data[2])*10; //goes in mm
    $insert_array["leaf_height"] = str_replace(',', '.',$paper_size_data[3])*10; //goes in mm
    $insert_array["leaf_qty_per_sheet"] = $paper_size_data[4]; //goes in mm

    DB::table('paper_sizes')->insert($insert_array);
  }

  //Validates if file is valid csv with correct header row
  private function check_header_row($header_row)
  {
    return !sizeof(array_diff($header_row,array("ancho hoja","alto hoja","ancho pliego","alto pliego","pliegos por hoja")));
  }
}
