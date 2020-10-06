<?php
$client_name = get_client_name($all_input["client_id"]);
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
