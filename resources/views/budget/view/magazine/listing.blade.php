<?php
use App\Classes\Calculation\Magazine\MagazineCalculation;

$client_id = get_form_value("client_id");
$budget_name = get_form_value("budget_name");
$copy_qty = get_form_value("copy_qty");

$where = array();
if( $client_id )
  $where[] = ['magazine_jobs.client_id','=',$client_id];
if( $budget_name )
  $where[] = ['magazine_jobs.budget_name','LIKE',"%".$budget_name."%"];
if( $copy_qty )
  $where[] = ['magazine_jobs.copy_qty','=',$copy_qty];
if( $machine )
  $where[] = ['magazine_jobs.machine','=',$machine];

$budgets = DB::table('magazine_jobs')
->join('clients', 'clients.id', '=', 'magazine_jobs.client_id')
->where($where)
->select('clients.name as client_name','magazine_jobs.copy_qty as copy_qty','magazine_jobs.budget_name as budget_name','magazine_jobs.created_at as created_at',
        'magazine_jobs.id as magazine_job_id')->get();

?>
<div class="container">
  <br>
  <div class="card" style="width: 80rem;">
    <div class="card-header">Listado de presupuestos comunes</div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <form method="GET" action="/budget/view/common/listing">
            <tr>
              <th scope="col">
                Nombre<br>
                <input type="text" size="15" name="budget_name" id="budget_name" value="{{$budget_name}}">
                @error('budget_name')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
              </th>
              <th scope="col">
                Cliente<br>
                <select id="client_id" name="client_id">
                  <option value=""></option>
                  @foreach(get_clients() as $client)
                    <option value="{{$client->id}}"
                      @if($client_id == $client->id )
                        selected
                        @endif
                    >
                      {{$client->name}}
                    </option>
                  @endforeach
                </select>
              </th>
              <th scope="col">
                Cantidad de ejemplares<br>
                <input type="text" size="15" name="copy_qty" id="copy_qty" value="{{$copy_qty}}">
                @error('copy_qty')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
              </th>
              <th scope="col">
                Fecha creación<br>
                <button type="submit" style="font-size:15px;height:30px;" class="btn btn-primary">
                  {{ __('Entrar') }}
                </button>
              </th>
            </tr>
          </form>
        </thead>
        <tbody>
          @foreach($budgets as $budget)
            <tr>
              <td>
                <a href="/budget/view/magazine/show_job/{{$budget->magazine_job_id}}">{{$budget->budget_name}}</a>
              </td>
              <td>
                {{$budget->client_name}}
              </td>
              <td>
                {{$budget->copy_qty}}
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
