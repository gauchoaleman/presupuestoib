<?php
namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigPages extends Controller
{
  private function check_job_data_completion($job_data,$page_qty)
  {
    for( $i=0;$i<=$page_qty/4;$i++ ){
      //By foil
      if( !($job_data[$i]["paper_type_id"] && $job_data[$i]["paper_color_id"] && $job_data[$i]["weight"] &&
          $job_data[$i]["front_color_qty"] && $job_data[$i]["front_machine"] &&
          $job_data[$i]["back_color_qty"] && $job_data[$i]["back_machine"]) )
        return FALSE;
    }
    return TRUE;
  }

  private function form_complete($form_data)
  {
    if( isset($form_data["job_data"]) && $this->check_job_data_completion($form_data["job_data"],$form_data["page_qty"]) )
      return TRUE;
    else
      return FALSE;
  }

  public function __invoke(Request $request)
  {
    if( $this->form_complete($_POST) ){
      $messages = [
      ];
      $v = Validator::make($request->all(),[],
        $messages
      );

      if ($v->fails())
        return redirect()->back()->withInput($request->input())->withErrors($v->errors());
      else
        return $this->show_page_with_menubars("budget/calculate/magazine/select_papers");
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/config_pages");
  }
}
?>
