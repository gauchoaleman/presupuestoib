<?php
$paper_prices = DB::table('paper_prices')
->join('paper_types', 'paper_types.id', '=', 'paper_prices.paper_type_id')
->join('paper_colors', 'paper_colors.id', '=', 'paper_prices.paper_color_id')
->where('paper_prices_set_id', $_GET["paper_prices_set_id"])
->select('paper_types.name as paper_type','paper_prices.height','paper_prices.width','paper_prices.weight','paper_colors.name as paper_color',
'paper_prices.sheet_price')->get();
$dollar_price = get_dollar_price();

?>
<div class="container">
<br>
<div class="card" style="width: 80rem;">
    <div class="card-header">Listado de precios</div>
    <div class="card-body">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Tipo</th>
      <th scope="col">Alto</th>
      <th scope="col">Ancho</th>
      <th scope="col">Peso</th>
      <th scope="col">Color</th>
      <th scope="col">Precio hoja</th>
    </tr>
  </thead>
  <tbody>
@foreach($paper_prices as $paper_price)
  <tr>
  <td>
    {{$paper_price->paper_type}}</a>
  </td>
  <td>
    {{$paper_price->height}}</a>
  </td>
  <td>
    {{$paper_price->width}}</a>
  </td>
  <td>
    {{$paper_price->weight}}</a>
  </td>
  <td>
    {{$paper_price->paper_color}}</a>
  </td>
  <td>
    {{$paper_price->sheet_price*$dollar_price}}</a>
  </td>
  </tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
