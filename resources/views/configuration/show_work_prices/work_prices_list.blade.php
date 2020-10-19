<?php
$work_prices = DB::table('work_prices')
->where('work_prices_set_id', $_GET["work_prices_set_id"])
->select('*')->get();
$dollar_price = get_dollar_price();
?>
<div class="container">
  <br>
  <div class="card" style="width: 80rem;">
    <div class="card-header">Listado de precios de trabajos</div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Nombre
            </th>
            <th scope="col">
              Precio
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($work_prices as $work_price)
            <tr>
              <td>
                {{$work_price->name}}
              </td>
              <td>
                {{$work_price->price*$dollar_price}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
