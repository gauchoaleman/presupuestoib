<?php
namespace App\Classes\Calculation\Magazine;
use App\Classes\Calculation\Calculation as Calculation;
use DB;

class MagazineCalculation extends Calculation
{
  public $finishing_array = array("Gramp"=>"Abrochar","Bind"=>"Encuadernar","Ring"=>"Anillar");
  public $mounting_array = array("Easy"=>"Fácil","Complicated"=>"Complicado");

  public function calculate_result($result_input)
  {
    
  }
}
?>
