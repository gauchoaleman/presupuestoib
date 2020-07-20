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

if (!$back_color_qty) {
    $back_color_qty = 0;
}
?>
<div class="container">
  <br>
  <form method="POST" action="/budget/calculate/common/show_result">
    @include('budget.calculate.common.job_detail')
    <br>
    <div class="card" style="width: 200%;">
      <div class="card-header">Tamaños papel</div>
      <div class="card-body">

        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">
                <div align="center">
                  Elegir
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ancho hoja
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Alto hoja
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ctd. pliegos ancho
                </div>
              </th>
              <th scope="col">
                <div align="center">
                Ctd. pliegos alto
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ancho pliego
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Alto pliego
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ctd. de poses ancho
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ctd. de poses alto
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Trabajo ancho
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Trabajo alto
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Posición
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Frente/Dorso
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Ancho pliego sin bordes
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Alto pliego sin bordes
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Resto (mmxmm)
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Resto ancho (mm)
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Resto alto (mm)
                </div>
              </th>
              <th scope="col">
                <div align="center">
                  Motivo rechazo
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($result["all_sizes"] as $size)

            {{--@if( $size["sheet_width"] == 880 && $size["sheet_height"]==630 && $size["leaf_width_qty"] == 2 && $size["leaf_height_qty"]==2)--}}
            <tr>
              <td>
                <div align="center">
                  <input type="radio"
                  @if ($loop->first)
                  checked
                  @endif

                  id="paper_data" name="paper_data" value="{{$size['paper_price_id']}}/{{$size["leaf_width"]}}/{{$size["leaf_height"]}}/{{$size["leaf_width_qty"]}}/{{$size["leaf_height_qty"]}}/{{$size["pose_width_qty"]}}/{{$size["pose_height_qty"]}}/{{$size["position"]}}/{{$size["front_back"]}}">
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["sheet_width"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["sheet_height"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_width_qty"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_height_qty"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_width"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_height"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["pose_width_qty"]}}
                  @if( $size["front_back"] == "front_back_width")
                    (frente/dorso)
                  @endif
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["pose_height_qty"]}}
                  @if( $size["front_back"] == "front_back_height")
                    (frente/dorso)
                  @endif
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["job_width"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["job_height"]}}
                </div>
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
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_width_without_borders"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["leaf_height_without_borders"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["rest"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["width_rest"]}}
                </div>
              </td>
              <td>
                <div align="center">
                  {{$size["height_rest"]}}
                </div>
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
      <button type="submit" class="btn btn-primary" name="button_action" value="show_result">
        {{ __('Ver resultado') }}
      </button>
    </div>
  </form>
</div>
