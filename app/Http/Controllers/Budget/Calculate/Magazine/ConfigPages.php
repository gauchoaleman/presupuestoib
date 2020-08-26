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
            $unique_paper["weight"] == $paper["weight"] &&
            ( ($unique_paper["front_machine"] == $paper["front_machine"] && $unique_paper["back_machine"] == $paper["back_machine"]) ||
              ($unique_paper["front_machine"] == $paper["back_machine"] && $unique_paper["back_machine"] == $paper["front_machine"]) )
            ){
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

  private function sizes_intersection($sizes1,$sizes2)
  {

  }
  
  private function calculate_sizes($paper,$pose_width,$pose_height)
  {
    $magazine_calculation = new MagazineCalculation();
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
      if( $paper["front_machine"] == $paper["back_machine"] )
        $size_res = $magazine_calculation->calculate_size($size->id,$size->width,$size->height,$pose_width,$pose_height,$front_color_qty,$back_color_qty,FALSE,$paper["front_machine"],FALSE);    //calculate
      else {
        $front_sizes = $magazine_calculation->calculate_size($size->id,$size->width,$size->height,$pose_width,$pose_height,$front_color_qty,$back_color_qty,FALSE,$paper["front_machine"],FALSE);    //calculate
        $back_sizes = $magazine_calculation->calculate_size($size->id,$size->width,$size->height,$pose_width,$pose_height,$front_color_qty,$back_color_qty,FALSE,$paper["back_machine"],FALSE);    //calculate
        $size_res = $this->sizes_intersection($front_sizes,$back_sizes);
      }
      //print($size->width."x".$size->height.": "); //Bandera
      //print_r($size_res); //Bandera
      $all_sizes = array_merge($size_res,$all_sizes);
    }
  }

  private function calculate_papers($papers,$pose_width,$pose_height)
  {
    foreach ($papers as $paper_number => $paper)
      $papers[$paper_number]["sizes"] = $this->calculate_sizes($paper);

    return $papers;
  }
  public function __invoke(Request $request)
  {
    if( $this->config_pages_form_complete($_POST) ){
      $unique_papers = $this->get_unique_papers($_POST["job_data"]);
      print_r($unique_papers);
      $papers_with_sizes = $this->calculate_papers($unique_papers,$_POST["pose_width"],$_POST["pose_height"]);

      return $this->show_page_with_menubars("budget/calculate/magazine/select_papers");
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/config_pages");
  }
}
?>
