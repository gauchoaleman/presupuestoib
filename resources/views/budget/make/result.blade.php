<div class="container">
<div class="card" style="width: 200%;">
    <div class="card-header">Tamaños papel</div>
    <div class="card-body">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><div align="center">Ancho hoja</div></th>
      <th scope="col"><div align="center">Alto hoja</div></th>
      <th scope="col"><div align="center">Ctd. pliegos ancho</div></th>
      <th scope="col"><div align="center">Ctd. pliegos alto</div></th>
      <th scope="col"><div align="center">Ancho pliego</div></th>
      <th scope="col"><div align="center">Alto pliego</div></th>
      <th scope="col"><div align="center">Ctd. de ejemplares ancho</div></th>
      <th scope="col"><div align="center">Ctd. de ejemplares alto</div></th>
      <th scope="col"><div align="center">Posición</div></th>
      <th scope="col"><div align="center">Frente/Dorso</div></th>
      <th scope="col"><div align="center">Ancho pliego sin bordes</div></th>
      <th scope="col"><div align="center">Alto pliego sin bordes</div></th>
      <th scope="col"><div align="center">Resto (mmxmm)</div></th>
      <th scope="col"><div align="center">Resto ancho (mm)</div></th>
      <th scope="col"><div align="center">Resto alto (mm)</div></th>
      <th scope="col"><div align="center">Motivo rechazo</div></th>
    </tr>
  </thead>
  <tbody>
@foreach($result["all_sizes"] as $size)

{{--@if( $size["paper_width"] == 950 && $size["paper_height"]==650 && $size["sheet_width_qty"] == 2 && $size["sheet_height_qty"]==2)--}}
  <tr>
  <td>
    <div align="center">{{$size["paper_width"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["paper_height"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["sheet_width_qty"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["sheet_height_qty"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["sheet_width"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["sheet_height"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["width_qty"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["height_qty"]}}</div>
  </td>
  <td>
    <div align="center">
    @switch($size["position"])
    @case("normal")
        Normal
        @break

    @case("lying")
        Acostado
        @break

    @default
        -
    @endswitch
    </div>
  </td>
  <td>
    <div align="center">
    @switch($size["front_back"])
    @case("normal")
        Normal
        @break
    @case("front_back_width")
        Frente/Dorso a lo ancho
        @break
    @case("front_back_height")
        Frente/Dorso a lo alto
        @break
    @default
        -
    @endswitch
  </td>
  <td>
    <div align="center">{{$size["sheet_width_without_borders"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["sheet_height_without_borders"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["rest"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["width_rest"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["height_rest"]}}</div>
  </td>
  <td>
    <div align="center">
      @foreach($size["continue"] as $cont)
        {{$cont}}<br>


      @endforeach
      @if( !sizeof($size["continue"]))
      Aceptado
      @endif
    </div>
  </td>
  </tr>
{{--@endif--}}
@endforeach
</tbody>
</table>
</div>
</div>
</div>
