<?php
$leaf_sizes_sets = DB::table('leaf_sizes_sets')->orderBy('id', 'desc')->select('*')->get();
?>
<div class="container">
  <br>
  <div class="card" style="width: 30rem;">
    <div class="card-header">
      Listado de sets
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Id
            </th>
            <th scope="col">
              Fecha
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($leaf_sizes_sets as $set)
            <tr>
              <td>
                <a href='/configuration/show_leaf_sizes?leaf_sizes_set_id={{$set->id}}'>{{$set->id}}</a>
              </td>
              <td>
                <?php $date = new DateTime($set->created_at); ?>
                {{$date->format('d/m/Y')}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
