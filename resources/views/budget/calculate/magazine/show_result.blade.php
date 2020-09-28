<?php
$client_name = get_client_name($all_input["client_id"]);

 ?>
<div class="container">
  <br>
  <h1 align="center">{{$all_input["budget_name"]}}</h1>
  <h2 align="center">Cliente: {{$client_name ?? ''}}</h2>
  <form method="POST" action="/budget/calculate/common/show_job_paper" target="_blank">
    @csrf
    {{--<input type="hidden" name="paper_data" value="{{$all_input["paper_data"]}}">--}}
    @include('budget.calculate.magazine.show_result.job_detail_card')
    <br>
    @include('budget.calculate.magazine.show_result.job_result_card')
  </form>
</div>
