<?php
$paper_type = get_paper_type($all_input["paper_type_id"]);
$paper_color = get_paper_color($all_input["paper_color_id"]);
$client_name = get_client_name($all_input["client_id"]);
$dollar_price = get_dollar_price(isset($dollar_price_id)?$dollar_price_id:0);
?>
<div class="container">
  <br>
  <h1 align="center">{{$all_input["budget_name"]}}</h1>
  <h2 align="center">Cliente: {{$client_name}}</h2>
  <form method="POST" action="/budget/calculate/common/show_job_paper" target="_blank">
    @csrf
    <input type="hidden" name="paper_data" value="{{$all_input["paper_data"]}}">
    @include('budget.calculate.common.show_result.job_detail_card')
    <br>
    @include('budget.calculate.common.show_result.job_result_card')

  </form>
</div>
