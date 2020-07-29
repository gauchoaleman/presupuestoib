<?php
$clients = DB::table('clients')->orderBy('id', 'desc')->select('*')->get();
?>
<div class="container">
  <br>
  <div class="card" style="width: 50rem;">
    <div class="card-header">
      Listado clientes
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Fecha agregado
            </th>
            <th scope="col">
              Nombre
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($clients as $client)
            <tr>
              <td>
                <?php $date = new DateTime($client->created_at); ?>
                {{$date->format('d/m/Y')}}
              </td>
              <td>
                {{$client->name}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
