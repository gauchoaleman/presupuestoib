<?php
$client_name = get_client_name($all_input["client_id"]);
?>
<div class="container">
  <br>
  <h1 align="center">{{$all_input["budget_name"]}}</h1>
  <h2 align="center">Cliente: {{$client_name}}</h2>
  <?php $date = new DateTime($all_input["created_at"]);?>
  <h2 align="center">Fecha: {{$date->format('d/m/Y')}}</h2>
  @if( !isset($_GET["actual_dollar"]))
    <a href="/budget/view/magazine/show_job/{{$all_input["magazine_job_id"]}}?actual_dollar=1">Ver con dólar actual</a><br>
    <form method="POST" action="/budget/view/magazine/show_job/{{$all_input["magazine_job_id"]}}" target="_blank">
  @else
    <a href="/budget/view/magazine/show_job/{{$all_input["magazine_job_id"]}}">Ver con dólar original</a><br>
    <form method="POST" action="/budget/view/magazine/show_job/{{$all_input["magazine_job_id"]}}?actual_dollar=1" target="_blank">
  @endif
    @csrf
    @include('budget.view.magazine.show_job.job_detail_card')
    <br>
    @include('budget.view.magazine.show_job.job_result_card')
  </form>
</div>
