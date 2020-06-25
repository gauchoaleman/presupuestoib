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

  <div class="card" style="width: 50rem;">
      <div class="card-header">Detalle trabajo</div>
      <div class="card-body">

<form method="POST" action="/budget/calculate/common/show_result">
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
</form><br>

<div class="card" style="width: 50rem;">
    <div class="card-header">Resultado</div>
    <div class="card-body">

      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Papel:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">Cantidad de hojas:</label>
              {{$sheet_qty}}
              <label class="col-md-6 col-form-label text-md-right">Pliegos ancho:</label>
              {{$leaf_width_qty}}
              <label class="col-md-6 col-form-label text-md-right">Pliegos alto:</label>
              {{$leaf_height_qty}}
              <label class="col-md-6 col-form-label text-md-right">Poses ancho:</label>
              {{$pose_width_qty}}
              <label class="col-md-6 col-form-label text-md-right">Poses alto:</label>
              {{$pose_height_qty}}
              <label class="col-md-6 col-form-label text-md-right">Costo:</label>
              ${{number_format($paper_price*get_dollar_price(),2)}}

          </div>
      </div>

      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Guillotina:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
              ${{number_format($guillotine_price*get_dollar_price(),2)}}
          </div>
      </div>

      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Planchas:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">Cantidad:</label>
              X
              <label class="col-md-6 col-form-label text-md-right">Costo:</label>
              {{$plates_price}}
          </div>
      </div>

      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Impresión:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
              ${{number_format($printing_price*get_dollar_price(),2)}}
          </div>
      </div>

@if( $fold )
      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Plegado:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">Arreglo:</label>
              ${{number_format($folding_arrangement_price*get_dollar_price(),2)}}

              <label class="col-md-6 col-form-label text-md-right">Por cantidad:</label>
              ${{number_format($folding_per_qty_price*get_dollar_price(),2)}}
            </div>
      </div>
@endif

@if( $punch )
      <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Troquelado:') }}</b></label>

          <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">Arreglo:</label>
              ${{number_format($punching_arrangement_price*get_dollar_price(),2)}}

              <label class="col-md-6 col-form-label text-md-right">Por cantidad:</label>
              ${{number_format($punching_per_qty_price*get_dollar_price(),2)}}
            </div>
          </div>
@endif
@if( $perforate )
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Perforado:') }}</b></label>

            <div class="col-md-6">
                <label class="col-md-6 col-form-label text-md-right">Arreglo:</label>
                ${{number_format($perforating_arrangement_price*get_dollar_price(),2)}}

                <label class="col-md-6 col-form-label text-md-right">Por cantidad:</label>
                ${{number_format($perforating_per_qty_price*get_dollar_price(),2)}}
              </div>
        </div>
@endif
@if( $lac )

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Laqueado:') }}</b></label>

            <div class="col-md-6">
                <label class="col-md-6 col-form-label text-md-right">Arreglo:</label>
                ${{number_format($lac_arrangement_price*get_dollar_price(),2)}}

                <label class="col-md-6 col-form-label text-md-right">Por cantidad:</label>
                ${{number_format($lac_per_qty_price*get_dollar_price(),2)}}
              </div>
        </div>
@endif

<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right"><b>{{ __('Total:') }}</b></label>

    <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">&nbsp;</label>
        ${{number_format($total*get_dollar_price(),2)}}
    </div>
</div>
</div>
</div>
</div>
