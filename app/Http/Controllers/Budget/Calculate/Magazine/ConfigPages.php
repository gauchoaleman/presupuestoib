<?php
namespace App\Http\Controllers\Budget\Calculate\Magazine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Classes\Calculation\Magazine\MagazineCalculation;

class ConfigPages extends Controller
{
  private function unique_paper_condition( $unique_paper,$paper )
  {
    $same_paper = $unique_paper["paper_type_id"] == $paper["paper_type_id"] && $unique_paper["weight"] == $paper["weight"] &&
                  $unique_paper["paper_color_id"] == $paper["paper_color_id"];
    $same_colors = $unique_paper["front_color_qty"] == $paper["front_color_qty"] && $unique_paper["back_color_qty"] == $paper["back_color_qty"];
    $same_machines = $unique_paper["front_machine"] == $paper["front_machine"] && $unique_paper["back_machine"] == $paper["back_machine"];
    $paper_pantone = isset($paper["front_pantone"]) || isset($paper["back_pantone"]);
    $unique_paper_pantone = isset($unique_paper["front_pantone"]) || isset($unique_paper["back_pantone"]);
    $ret = $same_paper && $same_colors && $same_machines && !$paper_pantone && !$unique_paper_pantone;
    return $ret;
  }
  //Detects common foils and reorders them
  private function get_unique_papers($page_papers)
  {
    $unique_papers = array();

    foreach( $page_papers as $foil_number => $paper ){
      $found_paper = FALSE;
      foreach( $unique_papers as $unique_paper_number => $unique_paper ){
        if( $this->unique_paper_condition( $unique_paper,$paper )) {
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

  //Checks out if job form is completed
  private function check_job_data_completion($job_data,$page_qty)
  {
    for( $foil_number=0;$foil_number<=$page_qty/4;$foil_number++ ){
      //By foil
      $paper_completed = $job_data[$foil_number]["paper_type_id"] && $job_data[$foil_number]["paper_color_id"] && $job_data[$foil_number]["weight"];
      $machines_completed = $job_data[$foil_number]["front_machine"] && $job_data[$foil_number]["back_machine"];
      if( !( $paper_completed && $machines_completed) )
        return FALSE;
    }
    return TRUE;
  }

  //Checks out if job form is completed
  private function config_pages_form_complete($form_data)
  {
    return isset($form_data["job_data"]) && $this->check_job_data_completion($form_data["job_data"],$form_data["page_qty"]);
  }

  //Calculates size intersection (for different machines on same foil)
  private function sizes_intersection($sizes1,$sizes2)
  {
    //print("Sizes1");                  //Bandera
    //print_r($sizes1);                 //Bandera
    //print("Sizes2");                  //Bandera
    //print_r($sizes2);                 //Bandera
    //print("Intersection:");           //Bandera
    //print_r(array_uintersect($sizes1,$sizes2,"sizes_compare"));   //Bandera
    return array_uintersect($sizes1,$sizes2,"sizes_compare");
  }

  //Get possible sizes for some unnique paper
  private function calculate_sizes($unique_paper,$pose_width,$pose_height)
  {
    $magazine_calculation = new MagazineCalculation();
    $sizes_result = DB::table('paper_prices')->select('id','width','height')->
    where('paper_type_id', '=', $unique_paper["paper_type_id"])->
    where('paper_color_id', '=', $unique_paper["paper_color_id"])->
    where('weight', '=', $unique_paper["weight"])->
    where('paper_prices_set_id', '=', get_latest_paper_price_set_id())->
    get();
    //print_r($sizes_result); //Bandera
    $foil_width = $pose_width*2;    //foil width is double magazine width
    $sizes_res = array();
    $all_sizes = array();
    foreach ($sizes_result as $size) {
      $sizes_res = $magazine_calculation->calculate_size($size->id,$size->width,$size->height,$foil_width,$pose_height,$unique_paper["front_color_qty"],
                     $unique_paper["back_color_qty"],FALSE,$unique_paper["front_machine"],$unique_paper["back_machine"],FALSE);    //calculate
      $all_sizes = array_merge($sizes_res,$all_sizes);
    }
    aasort($all_sizes,"rest");
    return $all_sizes;
  }

  //Get possible sizes for different papers
  private function calculate_papers($unique_papers,$pose_width,$pose_height)
  {
    foreach ($unique_papers as $unique_paper_number => $unique_paper)
      $unique_papers[$unique_paper_number]["sizes"] = $this->calculate_sizes($unique_paper,$pose_width,$pose_height);

    return $unique_papers;
  }

  public function __invoke(Request $request)
  {
    if( $this->config_pages_form_complete($_POST) ){
      $unique_papers = $this->get_unique_papers($_POST["job_data"]);
      //print_r($unique_papers);    //Bandera

      $unique_papers_with_sizes = $this->calculate_papers($unique_papers,$_POST["pose_width"],$_POST["pose_height"]);
      //print_r($unique_papers_with_sizes);     //Bandera
      $form_data = array();
      $form_data["unique_papers_with_sizes"] = $unique_papers_with_sizes;
      return $this->show_page_with_menubars("budget/calculate/magazine/select_papers","",$form_data);
    }
    else
      return $this->show_page_with_menubars("budget/calculate/magazine/config_pages");
  }
}
?>
