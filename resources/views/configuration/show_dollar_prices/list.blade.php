<?php
$dollar_prices = DB::table('dollar_prices')->orderBy('id', 'desc')->select('*')->get();
?>
<div class="container">
  <br>
  <div class="card" style="width: 50rem;">
    <div class="card-header">
      Precios dólar
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Fecha
            </th>
            <th scope="col" style="text-align:right">
              Costo
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($dollar_prices as $dollar_price)
            <tr>
              <td>
                <?php $date = new DateTime($dollar_price->created_at); ?>
                {{$date->format('d/m/Y')}}
              </td>
              <td align="right">
                {{$dollar_price->amount}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
