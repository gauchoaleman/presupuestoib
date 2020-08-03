<?php
$budgets = DB::table('common_jobs')
->join('clients', 'clients.id', '=', 'common_jobs.client_id')
->select('clients.name as client_name','common_jobs.machine as machine','common_jobs.copy_qty as copy_qty','common_jobs.budget_name as budget_name','common_jobs.created_at as created_at')->get();
$dollar_price = get_actual_dollar_price();
?>
<div class="container">
  <br>
  <div class="card" style="width: 80rem;">
    <div class="card-header">Listado de presupuestos comunes</div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              Cliente
            </th>
            <th scope="col">
              Nombre
            </th>
            <th scope="col">
              Cantidad de ejemplares
            </th>
            <th scope="col">
              Máquina
            </th>
            <th scope="col">
              Fecha creación
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($budgets as $budget)
            <tr>
              <td>
                {{$budget->client_name}}</a>
              </td>
              <td>
                {{$budget->budget_name}}</a>
              </td>
              <td>
                {{$budget->copy_qty}}</a>
              </td>
              <td>
                {{$budget->machine}}</a>
              </td>
              <td>
                <?php $date = new DateTime($budget->created_at); ?>
                {{$date->format('d/m/Y')}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
