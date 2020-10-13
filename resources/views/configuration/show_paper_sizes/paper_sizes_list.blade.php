<?php
$paper_sizes = DB::table('paper_sizes')
->where('paper_sizes_set_id', $_GET["paper_sizes_set_id"])
->select('*')->get();
$dollar_price = get_dollar_price();
?>
<div class="container">
  <br>
  <div class="card" style="width: 80rem;">
    <div class="card-header">Listado de precios</div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Ancho hoja
            </th>
            <th scope="col">
              Alto hoja
            </th>
            <th scope="col">
              Ancho pliego
            </th>
            <th scope="col">
              Alto pliego
            </th>
            <th scope="col">
              Pliegos por hoja
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($paper_sizes as $paper_size)
            <tr>
              <td>
                {{$paper_size->sheet_width}}
              </td>
              <td>
                {{$paper_size->sheet_height}}
              </td>
              <td>
                {{$paper_size->leaf_width}}
              </td>
              <td>
                {{$paper_size->leaf_height}}
              </td>
              <td>
                {{$paper_size->leaf_qty_per_sheet}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
