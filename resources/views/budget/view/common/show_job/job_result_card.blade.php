<div class="card" style="width: 70rem;">
  <div class="card-header">
    Resultado
  </div>
  <div class="card-body">
    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Papel:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          Cantidad de hojas:
        </label>
        {{$result["sheet_qty_and_excess"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Tamaño hoja:
        </label>
        {{$result["sheet_size"]["width"]}}x{{$result["sheet_size"]["height"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Pliegos ancho:
        </label>
        {{$all_input["leaf_width_qty"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Pliegos alto:
        </label>
        {{$all_input["leaf_height_qty"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Tamaño pliego:
        </label>
        {{$all_input["leaf_width"]}}x{{$all_input["leaf_height"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Poses ancho:
        </label>
        {{$all_input["pose_width_qty"]}}@if( $all_input["front_back"] == "front_back_width" ) Frente/Dorso @endif
        <label class="col-md-6 col-form-label text-md-right">
          Poses alto:
        </label>
        {{$all_input["pose_height_qty"]}}@if( $all_input["front_back"] == "front_back_height" ) Frente/Dorso @endif
        <label class="col-md-6 col-form-label text-md-right">
          Costo:
        </label>
        ${{number_format($result["paper_price"]*$result["dollar_price"],2)}}
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
        ${{number_format($result["guillotine_price"]*$result["dollar_price"],2)}}
      </div>
    </div>

    @if( $all_input["machine_washing_qty"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Lavados de máquina:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["washing_machine_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Planchas:') }}</b>
      </label>
      <div class="col-md-6">
        @foreach(array("Adast","GTO52","GTO46") as $each_machine)
          @if( isset($result["printing_and_plate_info"]["plate"]["qty"][$each_machine]))
            <label class="col-md-6 col-form-label text-md-right">
              {{$each_machine}}: {{$result["printing_and_plate_info"]["plate"]["qty"][$each_machine]}} unidades
            </label>
            ${{number_format($result["printing_and_plate_info"]["plate"]["prices"][$each_machine]*$result["dollar_price"],2)}}
          @endif
        @endforeach
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Impresión:') }}</b>
      </label>
      <div class="col-md-6">
        @foreach(array("Adast","GTO52","GTO46") as $each_machine)
          @if( isset($result["printing_and_plate_info"]["printing"]["qty"][$each_machine]))
          <label class="col-md-6 col-form-label text-md-right">
            {{$each_machine}}: {{$result["printing_and_plate_info"]["printing"]["qty"][$each_machine]}} copias
          </label>
          ${{number_format($result["printing_and_plate_info"]["printing"]["printing_prices"][$each_machine]*$result["dollar_price"],2)}}

          <label class="col-md-6 col-form-label text-md-right">
            Arreglo {{$each_machine}}:
          </label>
          ${{number_format($result["printing_and_plate_info"]["printing"]["arrangement_prices"][$each_machine]*$result["dollar_price"],2)}}

          @endif
        @endforeach

        @if($result["ink_prices"]["cmyk"])
          <label class="col-md-6 col-form-label text-md-right">
            Tinta CMYK:
          </label>
          ${{number_format($result["ink_prices"]["cmyk"]*$result["dollar_price"],2)}}
        @endif
        @if($result["ink_prices"]["pantone"])
          <label class="col-md-6 col-form-label text-md-right">
            Tinta Pantone:
          </label>
          ${{number_format($result["ink_prices"]["pantone"]*$result["dollar_price"],2)}}
        @endif

      </div>
    </div>

    @if( $all_input["fold_qty"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Plegado:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            Arreglo:
          </label>
          ${{number_format($result["folding"]["arrangement_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Por cantidad:
          </label>
          ${{number_format($result["folding"]["per_qty_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["punching_difficulty"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Troquelado:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            Arreglo:
          </label>
          ${{number_format($result["punching"]["arrangement_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Por cantidad:
          </label>
          ${{number_format($result["punching"]["per_qty_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Descartonar:
          </label>
          ${{number_format($result["punching"]["break_out_per_qty_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["perforate"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Perforado:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            Arreglo:
          </label>
          ${{number_format($result["perforating"]["arrangement_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Por cantidad:
          </label>
          ${{number_format($result["perforating"]["per_qty_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["tracing"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Trazado:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            Arreglo:
          </label>
          ${{number_format($result["tracing"]["arrangement_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Por cantidad:
          </label>
          ${{number_format($result["tracing"]["per_qty_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["lac"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Laqueado:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            Arreglo:
          </label>
          ${{number_format($result["lac"]["arrangement_price"]*$result["dollar_price"],2)}}
          <label class="col-md-6 col-form-label text-md-right">
            Por cantidad:
          </label>
          ${{number_format($result["lac"]["per_qty_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["various_finishing"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Acabados varios:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($all_input["various_finishing"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["mounting"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Montaje:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($all_input["mounting"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["shipping"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Envío:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($all_input["shipping"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $result["subtotal"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Subtotal:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["subtotal"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["discount_percentage"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Descuento:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["discount_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["plus_percentage"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Plus:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["plus_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Total:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($result["total"]*$result["dollar_price"],0)}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Valor dólar:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($result["dollar_price"],2)}}
      </div>
    </div>

    <div class="col-md-6">
      <button type="submit" class="btn btn-primary" name="button_action" value="show_job_paper">
        {{ __('Ver hoja encargo') }}
      </button>
    </div>
  </div>
</div>
