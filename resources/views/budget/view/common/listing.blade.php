<?php
use App\Classes\Calculation\Common\CommonCalculation;

$client_id = get_form_value("client_id");
$budget_name = get_form_value("budget_name");
$copy_qty = get_form_value("copy_qty");
$front_machine = get_form_value("front_machine");
$back_machine = get_form_value("back_machine");

$where = array();
if( $client_id )
  $where[] = ['common_jobs.client_id','=',$client_id];
if( $budget_name )
  $where[] = ['common_jobs.budget_name','LIKE',"%".$budget_name."%"];
if( $copy_qty )
  $where[] = ['common_jobs.copy_qty','=',$copy_qty];
if( $front_machine )
  $where[] = ['common_jobs.front_machine','=',$front_machine];
if( $back_machine )
  $where[] = ['common_jobs.back_machine','=',$back_machine];

$budgets = DB::table('common_jobs')
->join('clients', 'clients.id', '=', 'common_jobs.client_id')
->where($where)
->select('clients.name as client_name','common_jobs.front_machine as front_machine','common_jobs.back_machine as back_machine','common_jobs.copy_qty as copy_qty','common_jobs.budget_name as budget_name','common_jobs.created_at as created_at',
        'common_jobs.id as common_job_id')->get();

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
                Máquina frente<br>
                <select id="front_machine" name="front_machine">
                  <option value=""></option>
                  <?php $common_calculation = new CommonCalculation; ?>
                  @foreach($common_calculation->machine_list as $each_machine)
                    <option value="{{$each_machine}}"
                      @if($front_machine == $each_machine)
                        selected
                      @endif
                    >
                      {{$each_machine}}
                    </option>
                  @endforeach
                </select>
                @error('front_machine')
                  <div class="alert alert-danger">
                    {{ $message }}
                  </div>
                @enderror
              </th>
              <th scope="col">
                Máquina dorso<br>
                <select id="back_machine" name="back_machine">
                  <option value=""></option>
                  <?php $common_calculation = new CommonCalculation; ?>
                  @foreach($common_calculation->machine_list as $each_machine)
                    <option value="{{$each_machine}}"
                      @if($back_machine == $each_machine)
                        selected
                      @endif
                    >
                      {{$each_machine}}
                    </option>
                  @endforeach
                </select>
                @error('back_machine')
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
                <a href="/budget/view/common/show_job/{{$budget->common_job_id}}">{{$budget->budget_name}}</a>
              </td>
              <td>
                {{$budget->client_name}}
              </td>
              <td>
                {{$budget->copy_qty}}
              </td>
              <td>
                {{$budget->front_machine}}
              </td>
              <td>
                {{$budget->back_machine}}
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
