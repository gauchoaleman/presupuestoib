<div class="card" style="width: 200%;">
  <div class="card-header">Tamaños papel</div>
  <div class="card-body">
    @if( sizeof($unique_paper_with_sizes["sizes"]) )
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
          @foreach($unique_paper_with_sizes["sizes"] as $size)
          <tr>
            <td>
              <div align="center">
                <input type="radio"
                @if ($loop->first)
                checked
                @endif

                id="paper_data" name="paper_data[{{$unique_paper_key}}]" value="{{$size['paper_price_id']}}/{{$size["leaf_width"]}}/{{$size["leaf_height"]}}/{{$size["leaf_width_qty"]}}/{{$size["leaf_height_qty"]}}/{{$size["pose_width_qty"]}}/{{$size["pose_height_qty"]}}/{{$size["position"]}}/{{$size["front_back"]}}">
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
                {{$size["pose_width"]}}
              </div>
            </td>
            <td>
              <div align="center">
                {{$size["pose_height"]}}
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
                    @break
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
                    @break
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
          @endforeach
        </tbody>
      </table>
    @else
      No hay resultados para ésos parámetros. <a href="javascript:history.back()">Click acá</a> para volver.
    @endif
  </div>
</div>
