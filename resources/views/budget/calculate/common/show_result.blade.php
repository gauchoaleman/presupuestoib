<div class="container">

<div class="card" style="width: 50rem;">
    <div class="card-header">Resultado</div>
    <div class="card-body">

Papel: ${{number_format($paper_price*get_dollar_price(),2)}}<br>
Guillotina: ${{number_format($guillotine_price*get_dollar_price(),2)}}<br>
Plancha: ${{number_format($plates_price*get_dollar_price(),2)}}<br>
Impresión: ${{number_format($printing_price*get_dollar_price(),2)}}<br>
@if( $fold )
  Plegado:<br>
  &nbsp;Arreglo: ${{number_format($folding_arrangement_price*get_dollar_price(),2)}}<br>
  &nbsp;Por cantidad: ${{number_format($folding_per_qty_price*get_dollar_price(),2)}}<br>
@endif
@if( $punch )
  Troquelado:<br>
  &nbsp;Arreglo: ${{number_format($punching_arrangement_price*get_dollar_price(),2)}}<br>
  &nbsp;Por cantidad: ${{number_format($punching_per_qty_price*get_dollar_price(),2)}}<br>
@endif
@if( $perforate )
  Perforado:<br>
  &nbsp;Arreglo: ${{number_format($perforating_arrangement_price*get_dollar_price(),2)}}<br>
  &nbsp;Por cantidad: ${{number_format($perforating_per_qty_price*get_dollar_price(),2)}}<br>
@endif
@if( $lac )
  Laqueado:<br>
  &nbsp;Arreglo: ${{number_format($lac_arrangement_price*get_dollar_price(),2)}}<br>
  &nbsp;Por cantidad: ${{number_format($lac_per_qty_price*get_dollar_price(),2)}}<br>
@endif
<b>Total: ${{number_format($total*get_dollar_price(),2)}}</b>
</div>
</div>
</div>
