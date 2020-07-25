<?php
$paper_type = get_paper_type($paper_type_id);
$paper_color = get_paper_color($paper_color_id);
$client_name = get_client_name($client_id);
?>
<div class="container">
  <br>
  <h1 align="center">{{$budget_name}}</h1>
  <h2 align="center">Cliente: {{$client_name}}</h2>
  <form method="POST" action="/budget/calculate/common/show_job_paper" target="_blank">
    @csrf
    <input type="hidden" name="paper_data" value="{{$paper_data}}">
    @include('budget.calculate.common.show_result.job_detail')
    <br>
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
            {{$sheet_qty_and_excess}}
            <label class="col-md-6 col-form-label text-md-right">
              Tamaño hoja:
            </label>
            {{$sheet_size["width"]}}x{{$sheet_size["height"]}}
            <label class="col-md-6 col-form-label text-md-right">
              Pliegos ancho:
            </label>
            {{$leaf_width_qty}}
            <label class="col-md-6 col-form-label text-md-right">
              Pliegos alto:
            </label>
            {{$leaf_height_qty}}
            <label class="col-md-6 col-form-label text-md-right">
              Tamaño pliego:
            </label>
            {{$leaf_width}}x{{$leaf_height}}
            <label class="col-md-6 col-form-label text-md-right">
              Poses ancho:
            </label>
            {{$pose_width_qty}}@if( $front_back == "front_back_width" ) Frente/Dorso @endif
            <label class="col-md-6 col-form-label text-md-right">
              Poses alto:
            </label>
            {{$pose_height_qty}}@if( $front_back == "front_back_height" ) Frente/Dorso @endif
            <label class="col-md-6 col-form-label text-md-right">
              Costo:
            </label>
            ${{number_format($paper_price*$dollar_price,2)}}
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
            ${{number_format($guillotine_price*$dollar_price,2)}}
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Planchas:') }}</b>
          </label>
          <div class="col-md-6">
            @foreach(array("Adast","GTO52","GTO46") as $each_machine)
              @if( isset($printing_and_plate_info["plate"]["qty"][$each_machine]))
                <label class="col-md-6 col-form-label text-md-right">
                  {{$each_machine}}: {{$printing_and_plate_info["plate"]["qty"][$each_machine]}} unidades
                </label>
                ${{number_format($printing_and_plate_info["plate"]["prices"][$each_machine]*$dollar_price,2)}}
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
              @if( isset($printing_and_plate_info["printing"]["qty"][$each_machine]))
              <label class="col-md-6 col-form-label text-md-right">
                {{$each_machine}}: {{$printing_and_plate_info["printing"]["qty"][$each_machine]}} copias
              </label>
              ${{number_format($printing_and_plate_info["printing"]["printing_prices"][$each_machine]*$dollar_price,2)}}

              <label class="col-md-6 col-form-label text-md-right">
                Arreglo {{$each_machine}}:
              </label>
              ${{number_format($printing_and_plate_info["printing"]["arrangement_prices"][$each_machine]*$dollar_price,2)}}

              @endif
            @endforeach

            @if($ink_prices["cmyk"])
              <label class="col-md-6 col-form-label text-md-right">
                Tinta CMYK:
              </label>
              ${{number_format($ink_prices["cmyk"]*$dollar_price,2)}}
            @endif
            @if($ink_prices["pantone"])
              <label class="col-md-6 col-form-label text-md-right">
                Tinta Pantone:
              </label>
              ${{number_format($ink_prices["pantone"]*$dollar_price,2)}}
            @endif

          </div>
        </div>

        @if( $fold )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Plegado:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                Arreglo:
              </label>
              ${{number_format($folding_arrangement_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Por cantidad:
              </label>
              ${{number_format($folding_per_qty_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $punch )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Troquelado:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                Arreglo:
              </label>
              ${{number_format($punching_arrangement_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Por cantidad:
              </label>
              ${{number_format($punching_per_qty_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Descartonar:
              </label>
              ${{number_format($break_out_per_qty_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $perforate )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Perforado:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                Arreglo:
              </label>
              ${{number_format($perforating_arrangement_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Por cantidad:
              </label>
              ${{number_format($perforating_per_qty_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $tracing )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Trazado:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                Arreglo:
              </label>
              ${{number_format($tracing_arrangement_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Por cantidad:
              </label>
              ${{number_format($tracing_per_qty_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $lac )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Laqueado:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                Arreglo:
              </label>
              ${{number_format($lac_arrangement_price*$dollar_price,2)}}
              <label class="col-md-6 col-form-label text-md-right">
                Por cantidad:
              </label>
              ${{number_format($lac_per_qty_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $various_finishing )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Acabados varios:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($various_finishing*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $mounting )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Montaje:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($mounting*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $shipping )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Envío:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($shipping*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( $subtotal )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Subtotal:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($subtotal*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( isset($discount_price) )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Descuento:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($discount_price*$dollar_price,2)}}
            </div>
          </div>
        @endif

        @if( isset($plus_price) )
          <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">
              <b>{{ __('Plus:') }}</b>
            </label>
            <div class="col-md-6">
              <label class="col-md-6 col-form-label text-md-right">
                &nbsp;
              </label>
              ${{number_format($plus_price*$dollar_price,2)}}
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
            ${{number_format($total*$dollar_price,0)}}
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
            ${{number_format($dollar_price,2)}}
          </div>
        </div>

        <div class="col-md-6">
          <button type="submit" class="btn btn-primary" name="button_action" value="show_job_paper">
            {{ __('Ver hoja encargo') }}
          </button>
        </div>

      </div>
    </div>
  </form>
</div>
