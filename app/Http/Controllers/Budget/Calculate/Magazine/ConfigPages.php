<?php
namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigPages extends Controller
{
  private function get_unique_papers($page_papers)
  {
    $unique_papers = array();

    foreach( $page_papers as $foil_number => $paper ){
      $found_paper = FALSE;
      foreach( $unique_papers as $unique_paper_number => $unique_paper ){
        if( $unique_paper["paper_type_id"] == $paper["paper_type_id"] &&
            $unique_paper["paper_color_id"] == $paper["paper_color_id"] &&
            $unique_paper["weight"] == $paper["weight"] ){
          $unique_papers[$unique_paper_number]["foil_list"][] = $foil_number;
          $found_paper = TRUE;
        }
      }
      if( !$found_paper ){
        $unique_papers[] = $paper;
        $unique_papers[array_key_last($unique_papers)]["foil_list"][] = $foil_number;
      }
    }
    return $unique_papers;
  }

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

  private function config_pages_form_complete($form_data)
  {
    return isset($form_data["job_data"]) && $this->check_job_data_completion($form_data["job_data"],$form_data["page_qty"]);
  }

  public function __invoke(Request $request)
  {
    if( $this->config_pages_form_complete($_POST) ){
      $unique_papers = $this->get_unique_papers($_POST["job_data"]);
      print_r($unique_papers);

      return $this->show_page_with_menubars("budget/calculate/magazine/select_papers");
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/config_pages");
  }
}
?>
