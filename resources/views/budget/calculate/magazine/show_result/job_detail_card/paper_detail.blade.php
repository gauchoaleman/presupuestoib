<?php
  use App\Classes\Calculation\Magazine\MagazineCalculation;
?>
<div class="form-group row">
  <label class="col-md-4 col-form-label text-md-right">
    <b>{{ __('Papel:') }}</b>
  </label>
  <div class="col-md-6">
    <label class="col-md-6 col-form-label text-md-right">
      Cantidad de hojas:
    </label>
    {{$paper_result["sheet_qty_and_excess"]}}
    <label class="col-md-6 col-form-label text-md-right">
      Tamaño hoja:
    </label>
    {{$paper_result["sheet_size"]["width"]}}x{{$paper_result["sheet_size"]["height"]}}
    <label class="col-md-6 col-form-label text-md-right">
      Pliegos ancho:
    </label>

    {{$paper_all_input["paper_data"]["leaf_width_qty"]}}
    <label class="col-md-6 col-form-label text-md-right">
      Pliegos alto:
    </label>
    {{$paper_all_input["paper_data"]["leaf_height_qty"]}}
    <label class="col-md-6 col-form-label text-md-right">
      Tamaño pliego:
    </label>
    {{$paper_all_input["paper_data"]["leaf_width"]}}x{{$paper_all_input["paper_data"]["leaf_height"]}}
    <label class="col-md-6 col-form-label text-md-right">
      Poses ancho:
    </label>
    {{$paper_all_input["paper_data"]["pose_width_qty"]}}@if( $paper_all_input["paper_data"]["front_back"] == "front_back_width" ) Frente/Dorso @endif
    <label class="col-md-6 col-form-label text-md-right">
      Poses alto:
    </label>
    {{$paper_all_input["paper_data"]["pose_height_qty"]}}@if( $paper_all_input["paper_data"]["front_back"] == "front_back_height" ) Frente/Dorso @endif
    <label class="col-md-6 col-form-label text-md-right">
      Costo:
    </label>
    ${{number_format($paper_result["paper_price"]*$result["dollar_price"],2)}}
  </div>
</div>

<div class="form-group row">
  <label class="col-md-4 col-form-label text-md-right">
    <b>{{ __('Guillotina:') }}</b>
  </label>
  <div class="col-md-6">
    <label class="col-md-6 col-form-label text-md-right">
      &nbsp;
    </label>
    ${{number_format($paper_result["guillotine_price"]*$result["dollar_price"],2)}}
  </div>
</div>

<div class="form-group row">
  <label class="col-md-4 col-form-label text-md-right">
    <b>{{ __('Planchas:') }}</b>
  </label>
  <div class="col-md-6">
    <?php $magazine_calculation = new MagazineCalculation; ?>
    @foreach($magazine_calculation->machine_list as $each_machine)
      @if( isset($paper_result["printing_and_plate_info"]["plate"]["qty"][$each_machine]))
        <label class="col-md-6 col-form-label text-md-right">
          {{$each_machine}}: {{$paper_result["printing_and_plate_info"]["plate"]["qty"][$each_machine]}} unidades
        </label>
        ${{number_format($paper_result["printing_and_plate_info"]["plate"]["prices"][$each_machine]*$result["dollar_price"],2)}}
      @endif
    @endforeach
  </div>
</div>

<div class="form-group row">
  <label class="col-md-4 col-form-label text-md-right">
    <b>{{ __('Impresión:') }}</b>
  </label>
  <div class="col-md-6">
    @foreach($magazine_calculation->machine_list as $each_machine)
      @if( isset($paper_result["printing_and_plate_info"]["printing"]["qty"][$each_machine]))
      <label class="col-md-6 col-form-label text-md-right">
        {{$each_machine}}: {{$paper_result["printing_and_plate_info"]["printing"]["qty"][$each_machine]}} copias
      </label>
      ${{number_format($paper_result["printing_and_plate_info"]["printing"]["printing_prices"][$each_machine]*$result["dollar_price"],2)}}

      <label class="col-md-6 col-form-label text-md-right">
        Arreglo {{$each_machine}}:
      </label>
      ${{number_format($paper_result["printing_and_plate_info"]["printing"]["arrangement_prices"][$each_machine]*$result["dollar_price"],2)}}

      @endif
    @endforeach

    @if($paper_result["ink_prices"]["cmyk"])
      <label class="col-md-6 col-form-label text-md-right">
        Tinta CMYK:
      </label>
      ${{number_format($paper_result["ink_prices"]["cmyk"]*$result["dollar_price"],2)}}
    @endif
    @if($paper_result["ink_prices"]["pantone"])
      <label class="col-md-6 col-form-label text-md-right">
        Tinta Pantone:
      </label>
      ${{number_format($paper_result["ink_prices"]["pantone"]*$result["dollar_price"],2)}}
    @endif

  </div>
</div>

<div class="form-group row">
  <label class="col-md-4 col-form-label text-md-right">
    <b>{{ __('Total:') }}</b>
  </label>
  <div class="col-md-6">
    <label class="col-md-6 col-form-label text-md-right">
      &nbsp;
    </label>
    ${{number_format($paper_result["total"]*$result["dollar_price"],2)}}
  </div>
</div>
