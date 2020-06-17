<div class="container">

<div class="card" style="width: 50rem;">
    <div class="card-header">Resultado</div>
    <div class="card-body">

Papel: ${{number_format($paper_price,2)}}<br>
Guillotina: ${{number_format($guillotine_price,2)}}<br>
Plancha: ${{number_format($plates_price,2)}}<br>
Impresión: ${{number_format($printing_price,2)}}<br>
@if( $fold )
  Plegado: ${{number_format($folding_price,2)}}<br>
@endif
@if( $punch )
  Plegado:<br>
  &nbsp;Arreglo: ${{number_format($punching_arrangement_price,2)}}<br>
  &nbsp;Por cantidad: ${{number_format($punching_per_qty_price,2)}}<br>
@endif
@if( $perforate )
  Perforado:<br>
  &nbsp;Arreglo: ${{number_format($perforating_arrangement_price,2)}}<br>
  &nbsp;Por cantidad: ${{number_format($perforating_per_qty_price,2)}}<br>
@endif
@if( $lac )
  Laqueado:<br>
  &nbsp;Arreglo: ${{number_format($lac_arrangement_price,2)}}<br>
  &nbsp;Por cantidad: ${{number_format($lac_per_qty_price,2)}}<br>
@endif
<b>Total: ${{number_format($total,2)}}</b>
</div>
</div>
</div>
