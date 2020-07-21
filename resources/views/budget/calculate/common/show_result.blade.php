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
$pantone_1 = get_form_value("pantone_1");
$pantone_2 = get_form_value("pantone_2");
$pantone_3 = get_form_value("pantone_3");
$pose_qty = get_form_value("pose_qty");
$copy_qty = get_form_value("copy_qty");
$paper_price_id = get_form_value("paper_price_id");
$machine = get_form_value("machine");
$fold_qty = get_form_value("fold_qty");
$punching_difficulty = get_form_value("punching_difficulty");
$perforate = get_form_value("perforate");
$tracing = get_form_value("tracing");
$lac = get_form_value("lac");
$client_id = get_form_value("client_id");
$client_name = get_client_name($client_id);
$budget_name = get_form_value("budget_name");
$discount_percentage = get_form_value("discount_percentage");
$plus_percentage = get_form_value("plus_percentage");
$paper_data = get_form_value("paper_data");
if( !$back_color_qty )
  $back_color_qty = 0;
?>
<div class="container">
  <br>
  <h1 align="center">{{$budget_name}}</h1>
  <h2 align="center">Cliente: {{$client_name}}</h2>
  <form method="POST" action="/budget/calculate/common/show_job_paper" target="_blank">
    @csrf
    <input type="hidden" name="paper_data" value="{{$paper_data}}">
    @include('budget.calculate.common.job_detail')
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
