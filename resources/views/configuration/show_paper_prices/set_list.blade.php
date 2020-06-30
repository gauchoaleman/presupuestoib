<?php
$paper_prices_sets = DB::table('paper_prices_sets')->orderBy('id', 'desc')->select('*')->get();
?>
<div class="container">
<br>
<div class="card" style="width: 50rem;">
    <div class="card-header">Listado de sets</div>
    <div class="card-body">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Fecha</th>
    </tr>
  </thead>
  <tbody>
@foreach($paper_prices_sets as $set)
  <tr>
  <td>
  <a href='/configuration/show_paper_prices?paper_prices_set_id={{$set->id}}'>{{$set->id}}</a>
  </td>
  <td>
    <?php $date = new DateTime($set->created_at); ?>
    {{$date->format('d/m/Y')}}
  </td>
  </tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
