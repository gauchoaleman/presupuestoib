<?php
namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirstForm extends Controller
{
  private function form_complete()
  {
    if( isset($_POST["submit"]) && $_POST["submit"]=="first_form_complete"){
      return TRUE;
    }
    else
      return FALSE;
  }

  public function __invoke(Request $request)
  {
    if( $this->form_complete() ){
      $messages = [
        'pose_width.required' => 'Debe ingresar un ancho.',
        'pose_width.integer' => 'El ancho debe ser un entero.',
        'pose_width.gt' => 'El ancho debe ser mayor a cero.',
        'pose_height.required' => 'Debe ingresar un alto.',
        'pose_height.integer' => 'El alto debe ser un entero.',
        'pose_height.gt' => 'El alto debe ser mayor a cero.',
        'copy_qty.required' => 'Debe ingresar cantidad de ejemplares.',
        'copy_qty.integer' => 'La cantidad de ejemplares debe ser un entero.',
        'copy_qty.gt' => 'La cantidad de ejemplares debe ser mayor a cero.',
        'page_qty.required' => 'Debe ingresar cantidad de páginas.',
        'page_qty.integer' => 'La cantidad de páginas debe ser un entero.',
        'page_qty.gt' => 'La cantidad de páginas debe ser mayor a cero.',
        'finishing.required' => 'Debe seleccionar un acabado.',
        'client_id.required' => 'Debe seleccionar un cliente.',
        'budget_name.required' => 'Debe ingesar nombre de presupuesto.',
        'mounting.integer' => 'Montaje debe ser un entero.',
        'shipping.integer' => 'Envío debe ser un entero.',
        'discount_percentage.integer' => 'El descuento debe ser un entero.',
        'plus_percentage.integer' => 'El plus debe ser un entero.',
      ];
      $v = Validator::make($request->all(), [
        'pose_width' => ['required','integer','gt:0'],
        'pose_height' =>['required','integer','gt:0'],
        'copy_qty' => ['required','integer','gt:0'],
        'page_qty' => ['required','integer','gt:0',
          function ($attribute, $value, $fail) {
            if ($value % 4 !== 0)
                $fail('La cantidad de páginas debe ser divisible por 4.'); // your message
          }],
        'finishing' => ['required'],
        'client_id' => ['required'],
        'budget_name' => ['required'],
        'mounting' => ['integer'],
        'shipping' => ['integer'],
        'discount_percentage' => ['integer'],
        'plus_percentage' => ['integer']],
        $messages
      );

      if ($v->fails())
        return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      else
        return $this->show_page_with_menubars("budget/calculate/magazine/select_pages_paper");
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/first_form");
  }
}
?>
