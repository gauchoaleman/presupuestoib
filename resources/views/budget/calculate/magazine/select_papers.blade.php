<?php
use App\Classes\Calculation\Magazine\MagazineCalculation;
$pose_width = get_form_value("pose_width");
$pose_height = get_form_value("pose_height");
$copy_qty = get_form_value("copy_qty");
$page_qty = get_form_value("page_qty");
$finishing = get_form_value("finishing");
$machine_washing_qty = get_form_value("machine_washing_qty");
$mounting = get_form_value("mounting");
$client_id = get_form_value("client_id");
$client_name = get_client_name($client_id);
$budget_name = get_form_value("budget_name");
$shipping = get_form_value("shipping");
$discount_percentage = get_form_value("discount_percentage");
$plus_percentage = get_form_value("plus_percentage");

?>
<div class="container">
  <br>
  <form method="POST" action="/budget/calculate/magazine/config_pages">
    @csrf
    @include('budget.calculate.magazine.config_pages.job_detail_card')
    <input type="hidden" name="unique_papers_with_sizes" value="{{serialize($unique_papers_with_sizes)}}">
    <br>
    @foreach($unique_papers_with_sizes as $unique_paper_with_sizes)
      @foreach($unique_paper_with_sizes["foil_list"] as $foil_number)
        @if($foil_number==0)
          Tapa/Contratapa y retiros:<br>
        @else
          Folio {{$foil_number}}, Páginas {{$foil_number*2-1}}, {{$foil_number*2}}, {{$page_qty-2*($foil_number-1)-1}}, {{$page_qty-2*($foil_number-1)}}:<br>
        @endif
      @endforeach
      <br>

    @endforeach

  </form>
</div>
