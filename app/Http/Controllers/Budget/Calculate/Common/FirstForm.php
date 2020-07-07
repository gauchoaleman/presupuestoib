<?php

namespace App\Http\Controllers\Budget\Calculate\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class FirstForm extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  private function form_complete()
  {
    if( isset($_POST["paper_type_id"]) && isset($_POST["paper_color_id"]) && isset($_POST["weight"]) &&
    $_POST["paper_type_id"] && $_POST["paper_color_id"] && $_POST["weight"] ){
      return TRUE;
    }
    else
      return FALSE;
  }

  public function calculate_papers($paper_type_id, $paper_color_id, $weight, $width, $height,$front_color_qty,$back_color_qty,$pose_qty,$copy_qty,$machine)
  {
    $sizes_result = DB::table('paper_prices')->select('id','width','height')->
    where('paper_type_id', '=', $paper_type_id)->
    where('paper_color_id', '=', $paper_color_id)->
    where('weight', '=', $weight)->
    where('paper_prices_set_id', '=', get_latest_paper_price_set_id())->
    get();
    //print_r($sizes_result); //Bandera
    $size_res = array();
    $all_sizes = array();
    foreach ($sizes_result as $size) {
      $size_res = $this->calculate_size($size->id,$size->width,$size->height,$width,$height,$front_color_qty,$back_color_qty,$pose_qty,$machine);    //calculate
      //print($size->width."x".$size->height.": "); //Bandera
      //print_r($size_res); //Bandera
      $all_sizes = array_merge($size_res,$all_sizes);
    }
    //If there are no sizes, we calculate normal
    if( !sizeof($all_sizes) ){
      foreach ($sizes_result as $size) {
        $size_res = $this->calculate_size($size->id,$size->width,$size->height,$width,$height,$front_color_qty,$back_color_qty,$pose_qty,$machine,false);    //calculate
        //print($size->width."x".$size->height.": "); //Bandera
        //print_r($size_res); //Bandera
        $all_sizes = array_merge($size_res,$all_sizes);
      }
    }

    aasort($all_sizes,"rest");
    //print_r($all_sizes);    //Bandera
    $ret["all_sizes"] = $all_sizes;
    return $ret;
  }

  public function proc(Request $request)
  {
    if( $this->form_complete() ){
      $messages = [
        'width.required' => 'Debe ingresar un ancho.',
        'width.integer' => 'El ancho debe ser un entero.',
        'width.gt' => 'El ancho debe ser mayor a cero.',
        'height.required' => 'Debe ingresar un alto.',
        'height.integer' => 'El alto debe ser un entero.',
        'height.gt' => 'El alto debe ser mayor a cero.',
        'front_color_qty.required' => 'Debe ingresar colores de frente.',
        'front_color_qty.integer' => 'La cantidad de colores de frente debe ser un entero.',
        'front_color_qty.gt' => 'La cantidad de colores de frente debe ser mayor a cero.',
        'copy_qty.required' => 'Debe ingresar cantidad de ejemplares.',
        'copy_qty.integer' => 'La cantidad de ejemplares debe ser un entero.',
        'copy_qty.gt' => 'La cantidad de ejemplares debe ser mayor a cero.',
        'back_color_qty.integer' => 'La cantidad de colores de dorso debe ser un entero.',
        'machine.required' => 'Debe ingresar la máquina.',
        'fold_qty.integer' => 'La cantidad de pliegues debe ser un entero.',
        'client_id.required' => 'Debe seleccionar un cliente.',
        'budget_name.required' => 'Debe ingesar nombre de presupuesto.',
        'discount_percentage.integer' => 'El descuento debe ser un entero.',
        'plus_percentage.integer' => 'El plus debe ser un entero.',
      ];
      $v = Validator::make($request->all(), [
        'width' => 'required|integer|gt:0',
        'height' => 'required|integer|gt:0',
        'front_color_qty' => 'required|integer|gt:0',
        'back_color_qty' => 'integer',
        'copy_qty' => 'required|integer|gt:0',
        'machine' => 'required',
        'fold_qty' => 'integer',
        'client_id' => 'required',
        'budget_name' => 'required',
        'discount_percentage' => 'integer',
        'plus_percentage' => 'integer',],
        $messages
      );

      if ($v->fails())
        return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      else{
        $result = $this->calculate_papers($_POST["paper_type_id"], $_POST["paper_color_id"], $_POST["weight"], $_POST["width"], $_POST["height"],
        $_POST["front_color_qty"],$_POST["back_color_qty"],$_POST["pose_qty"],$_POST["copy_qty"],$_POST["machine"]);
        $data["result"]=$result;
        return $this->show_page_with_menubars("budget/calculate/common/select_paper","",$data);
      }
    }
    else
      return $this->show_page_with_menubars("budget/calculate/common/first_form");
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
