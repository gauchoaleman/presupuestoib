<?php
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
print("All input:");      //Bandera
print_r($all_input);      //Bandera
?>
<div class="container">
  <br>
  <h1 align="center">{{$all_input["budget_name"]}}</h1>
  <h2 align="center">Cliente: {{$client_name ?? ''}}</h2>
  <form method="POST" action="/budget/calculate/magazine/show_job_paper" target="_blank">
    @csrf
    <input type="hidden" name="unique_papers_with_sizes_serialized" value="{{$all_input["unique_papers_with_sizes_serialized"]}}">
    @include('budget.calculate.magazine.show_result.job_detail_card')
    <br>
    @include('budget.calculate.magazine.show_result.job_result_card')
  </form>
</div>
