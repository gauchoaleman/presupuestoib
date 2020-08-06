<?php
$paper_type = get_paper_type($all_input["paper_type_id"]);
$paper_color = get_paper_color($all_input["paper_color_id"]);
$client_name = get_client_name($all_input["client_id"]);
?>
<div class="container">
  <br>
  <h1 align="center">{{$all_input["budget_name"]}}</h1>
  <h2 align="center">Cliente: {{$client_name}}</h2>
  @if( !isset($_GET["actual_dollar"]))
    <a href="/budget/view/common/show_job/{{$all_input["common_job_id"]}}?actual_dollar=1">Ver con dólar actual</a><br>
    <form method="POST" action="/budget/view/common/show_job/{{$all_input["common_job_id"]}}" target="_blank">
  @else
    <a href="/budget/view/common/show_job/{{$all_input["common_job_id"]}}">Ver con dólar original</a><br>
    <form method="POST" action="/budget/view/common/show_job/{{$all_input["common_job_id"]}}?actual_dollar=1" target="_blank">
  @endif
    @csrf
    @include('budget.view.common.show_job.job_detail_card')
    <br>
    @include('budget.view.common.show_job.job_result_card')
  </form>
</div>
