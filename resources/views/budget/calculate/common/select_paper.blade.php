<?php
$paper_type_id = get_form_value("paper_type_id");
$paper_color_id = get_form_value("paper_color_id");
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
<form method="POST" action="/budget/calculate/common/select_paper">
  <div class="card" style="width: 50rem;">
      <div class="card-header">Datos ingresados</div>
      <div class="card-body">


  @csrf
  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Papel:') }}</b></label>

      <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">Tipo:</label>

          <select id="paper_type_id" name="paper_type_id" onchange="this.form.submit()" disabled>
            <option value=""></option>
            @foreach(get_paper_types() as $paper_type)
              <option value="{{$paper_type->id}}"
                @if($paper_type_id == $paper_type->id )
                selected
                @endif>{{$paper_type->name}}</option>
            @endforeach
          </select>
          @error('paper_type_id')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror

          <label class="col-md-6 col-form-label text-md-right">Color:</label>
          <select id="paper_color_id" name="paper_color_id" onchange="this.form.submit()" disabled>
            <option value=""></option>
            @if(isset($paper_type_id))
              @foreach(get_paper_colors($paper_type_id) as $paper_color)
                <option value="{{$paper_color->id}}"
                  @if($paper_color_id==$paper_color->id)
                  selected
                  @endif>{{$paper_color->name}}

                </option>
              @endforeach
            @endif
          </select>
          @error('paper_color_id')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror

          <label class="col-md-6 col-form-label text-md-right">Peso:</label>
          <select id="weight" name="weight" disabled>
            <option value=""></option>
            @if(isset($paper_type_id) && isset($paper_color_id))
              @foreach(get_paper_weights($paper_type_id,$paper_color_id) as $paper_weight)
                <option value="{{$paper_weight->weight}}"
                  @if($weight == $paper_weight->weight)
                  selected
                  @endif>

                  {{$paper_weight->weight}}
                </option>
              @endforeach
            @endif
          </select>
          @error('weight')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror

          <label class="col-md-6 col-form-label text-md-right">Ancho (mm):</label>
          <input type="text" size="5" name="width" value="{{$width}}" disabled>
          @error('width')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <label class="col-md-6 col-form-label text-md-right">Alto (mm):</label>
          <input type="text" size="5" name="height" value="{{$height}}" disabled>
          @error('height')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>


  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Colores:') }}</b></label>

      <div class="col-md-6">

          <label class="col-md-6 col-form-label text-md-right">Frente:</label>
          <input type="text" size="5" name="front_color_qty" value="{{$front_color_qty}}" disabled>
          @error('front_color_qty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          <label class="col-md-6 col-form-label text-md-right">Dorso:</label>
          <input type="text" size="5" name="back_color_qty" value="{{$back_color_qty}}" disabled>
          @error('back_color_qty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de Poses:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          <input type="text" size="5" name="pose_qty" value="{{$pose_qty}}" disabled>
          @error('pose_qty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de ejemplares:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          <input type="text" size="5" name="copy_qty" value="{{$copy_qty}}" disabled>
          @error('copy_qty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Máquina:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        <select id="machine" name="machine" disabled>
          <option value=""></option>
            @foreach(array("Adast","GTO52","GTO46") as $each_machine)
              <option value="{{$each_machine}}"
                @if($machine == $each_machine)
                selected
                @endif>

                {{$each_machine}}
              </option>
            @endforeach
        </select>
          @error('machine')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Cantidad de pliegues:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          <input type="text" size="5" name="fold_qty" disabled value="{{$fold_qty}}">
          @error('fold_qty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Dificultad troquel:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        <select id="punching_difficulty" name="punching_difficulty" disabled>
          <option value=""></option>
            @foreach(array(1,2,3,4) as $each_punching_difficulty)
              <option value="{{$each_punching_difficulty}}"
                @if($punching_difficulty == $each_punching_difficulty)
                selected
                @endif>

                {{$each_punching_difficulty}}
              </option>
            @endforeach
        </select>
          @error('punching_difficulty')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Perforar:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          <input type="checkbox" name="perforate" value="1"
          @if($perforate == "1")
          checked
          @endif disabled>
      </div>
  </div>

  <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Laca:') }}</b></label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
          <input type="checkbox" name="lac" value="1"
          @if($lac == "1")
          checked
          @endif disabled>
      </div>
  </div>

  </div>
  </div>

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
    <div align="center"><input type="radio" id="paper_size_id" name="paper_size_id" value="{{$size['paper_price_id']}}"></div>
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
