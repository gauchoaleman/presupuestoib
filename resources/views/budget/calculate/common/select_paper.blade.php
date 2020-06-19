<?php
$paper_type_id = get_form_value("paper_type_id");
$paper_type = get_paper_type($paper_type_id);
$paper_color_id = get_form_value("paper_color_id");
$paper_color = get_paper_color($paper_color_id);
$weight = get_form_value("weight");
$width = get_form_value("width");
$height = get_form_value("height");
$front_color_qty = get_form_value("front_color_qty");
$back_color_qty = get_form_value("back_color_qty");
$pose_qty = get_form_value("pose_qty");
$copy_qty = get_form_value("copy_qty");
$paper_price_id = get_form_value("paper_price_id");
$machine = get_form_value("machine");
$fold_qty = get_form_value("fold_qty");
$punching_difficulty = get_form_value("punching_difficulty");
$perforate = get_form_value("perforate");
$lac = get_form_value("lac");
if( !$back_color_qty )
  $back_color_qty = 0;
?>
<div class="container">
<form method="POST" action="/budget/calculate/common/show_result">
  <div class="card" style="width: 50rem;">
      <div class="card-header">Datos ingresados</div>
      <div class="card-body">


  @csrf
  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Papel:') }}</b></label>

      <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">Tipo:</label>
          <input type="hidden" name="paper_type_id" value="{{$paper_type_id}}">
          {{$paper_type}}
          <label class="col-md-6 col-form-label text-md-right">Color:</label>
          <input type="hidden" name="paper_color_id" value="{{$paper_color_id}}">
          {{$paper_color}}
          <label class="col-md-6 col-form-label text-md-right">Peso:</label>
          <input type="hidden" name="weight" value="{{$weight}}">
          {{$weight}}
          <label class="col-md-6 col-form-label text-md-right">Ancho (mm):</label>
          <input type="hidden" name="width" value="{{$width}}">
          {{$width}}
          <label class="col-md-6 col-form-label text-md-right">Alto (mm):</label>
          <input type="hidden" name="height" value="{{$height}}">
          {{$height}}
      </div>
  </div>


  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Colores:') }}</b></label>

      <div class="col-md-6">

          <label class="col-md-6 col-form-label text-md-right">Frente:</label>
          <input type="hidden" name="front_color_qty" value="{{$front_color_qty}}">
          {{$front_color_qty}}
          <label class="col-md-6 col-form-label text-md-right">Dorso:</label>
          <input type="hidden" name="back_color_qty" value="{{$back_color_qty}}">
          {{$back_color_qty}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de Poses:') }}</b></label>
      <input type="hidden" name="pose_qty" value="{{$pose_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        {{$pose_qty}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de ejemplares:') }}</b></label>
      <input type="hidden" name="copy_qty" value="{{$copy_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          {{$copy_qty}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Máquina:') }}</b></label>
      <input type="hidden" name="machine" value="{{$machine}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        {{$machine}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de pliegues:') }}</b></label>
      <input type="hidden" name="fold_qty" value="{{$fold_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          {{$fold_qty}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Dificultad troquel:') }}</b></label>
      <input type="hidden" name="punching_difficulty" value="{{$punching_difficulty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        {{$punching_difficulty}}
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Perforar:') }}</b></label>
      <input type="hidden" name="perforate" value="{{$perforate}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        @if( $perforate ) Si @else No @endif
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Laca:') }}</b></label>
      <input type="hidden" name="lac" value="{{$lac}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        @if( $lac ) Si @else No @endif
      </div>
  </div>

  </div>
  </div>
<br>
<div class="card" style="width: 200%;">
    <div class="card-header">Tamaños papel</div>
    <div class="card-body">

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><div align="center">Elegir</div></th>
      <th scope="col"><div align="center">Ancho hoja</div></th>
      <th scope="col"><div align="center">Alto hoja</div></th>
      <th scope="col"><div align="center">Ctd. pliegos ancho</div></th>
      <th scope="col"><div align="center">Ctd. pliegos alto</div></th>
      <th scope="col"><div align="center">Ancho pliego</div></th>
      <th scope="col"><div align="center">Alto pliego</div></th>
      <th scope="col"><div align="center">Ctd. de ejemplares ancho</div></th>
      <th scope="col"><div align="center">Ctd. de ejemplares alto</div></th>
      <th scope="col"><div align="center">Trabajo ancho</div></th>
      <th scope="col"><div align="center">Trabajo alto</div></th>
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

{{--@if( $size["paper_width"] == 880 && $size["paper_height"]==630 && $size["sheet_width_qty"] == 2 && $size["sheet_height_qty"]==2)--}}
  <tr>
  <td>
    <div align="center"><input type="radio"
      @if ($loop->first)
              checked
      @endif

      id="paper_data" name="paper_data" value="{{$size['paper_price_id']}}/{{$size["sheet_width_qty"]}}/{{$size["sheet_height_qty"]}}/{{$size["width_qty"]}}/{{$size["height_qty"]}}/{{$size["position"]}}/{{$size["front_back"]}}"></div>
  </td>
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
    <div align="center">{{$size["job_width"]}}</div>
  </td>
  <td>
    <div align="center">{{$size["job_height"]}}</div>
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
      Accepted
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
<div class="col-md-6">
      <button type="submit" class="btn btn-primary">
              {{ __('Entrar') }}
  </button>
</div>
</form>
</div>
