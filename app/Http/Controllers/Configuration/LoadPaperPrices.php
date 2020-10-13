<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

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
    if( isset($_POST["_token"]) ) {
      $filename = time().'.'.$request->file->extension();
      $request->file->move(public_path("uploads/paper_prices"), $filename);
      $csv_file = fopen("uploads/paper_prices/".$filename,"r"); // For production
      //$csv_file = fopen("uploads/paper_prices/test_file.txt","r"); //For testing
      $header_row = fgetcsv($csv_file,10000,",",'"'); //Loading header row
      if( !$this->check_header_row($header_row) )
        return $this->show_page_with_menubars("configuration/load_paper_prices/form","Archivo cargado inválido");
      $paper_prices_set_id = $this->get_new_paper_prices_set_id();
      for ($row = 1;($data = fgetcsv($csv_file,10000,",",'"'))   !== FALSE;$row++) {
        $count = count($data);
        $this->save_paper_price_row($paper_prices_set_id,$data);
      }
      return $this->show_page_with_menubars("home_page","Precios cargados.");
    }
    else
      return $this->show_page_with_menubars("configuration/load_paper_prices/form");
  }

  private function get_new_paper_prices_set_id()
  {
    $id = DB::table('paper_prices_sets')->insertGetId(array("created_at"=>date('Y-m-d H:i:s')));
    return $id;
  }

  private function existing_paper_color_id($paper_color_name)
  {
    $paper_color_count = DB::table('paper_colors')->where('name', $paper_color_name)->count();
    return $paper_color_count != 0; //returns 0 (false) if there was no result
  }

  private function get_paper_color_id($paper_color_name)
  {
    $paper_color = DB::table('paper_colors')->where('name', $paper_color_name)->first();
    return $paper_color->id; //returns 0 (false) if there was no result
  }

  private function get_new_paper_color_id($paper_color_name)
  {
    $id = DB::table('paper_colors')->insertGetId(array('name' => $paper_color_name));
    return $id;
  }

  private function  existing_paper_type_id($paper_type_name)
  {
    $paper_type_count = DB::table('paper_types')->where('name', $paper_type_name)->count();
    return $paper_type_count != 0; //returns 0 (false) if there was no result
  }

  private function get_paper_type_id($paper_type_name)
  {
    $paper_type = DB::table('paper_types')->where('name', $paper_type_name)->first();
    return $paper_type->id; //returns 0 (false) if there was no result
  }

  private function get_new_paper_type_id($paper_type_name)
  {
    $id = DB::table('paper_types')->insertGetId(array('name' => $paper_type_name));
    return $id;
  }

  private function save_paper_price_row($paper_prices_set_id,$paper_price_data)
  {
    $insert_array["paper_prices_set_id"] = $paper_prices_set_id;

    if( $this->existing_paper_type_id($paper_price_data[0]))
      $insert_array["paper_type_id"] = $this->get_paper_type_id($paper_price_data[0]);
    else
      $insert_array["paper_type_id"] = $this->get_new_paper_type_id($paper_price_data[0]);

    $insert_array["height"] = $paper_price_data[1]*10; //goes in mm
    $insert_array["width"] = $paper_price_data[2]*10; //goes in mm
    $insert_array["weight"] = $paper_price_data[3]; //goes in gramms

    if( !$paper_price_data[4] )   //If there isn't set color, it is set to white ("blanco")
      $paper_color = "blanco";
    else
      $paper_color = $paper_price_data[4];

    if( $this->existing_paper_color_id($paper_color))
      $insert_array["paper_color_id"] = $this->get_paper_color_id($paper_color);
    else
      $insert_array["paper_color_id"] = $this->get_new_paper_color_id($paper_color);

    $insert_array["sheet_price"] = str_replace(',', '.',$paper_price_data[9]); //goes in Dollars
    DB::table('paper_prices')->insert($insert_array);
  }

  //Validates if file is valid csv with correct header row
  private function check_header_row($header_row)
  {
    return !sizeof(array_diff($header_row,array("TIPO PAPEL","ALTO","ANCHO","GR.","Color","kg/RS","US/kg","Precio RS","x 1 hoja","final x hoja")));
  }
}
