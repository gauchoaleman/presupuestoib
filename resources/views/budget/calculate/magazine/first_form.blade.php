<?php
use App\Classes\Calculation\Magazine\MagazineCalculation;

$pose_width = get_form_value("pose_width");
$pose_height = get_form_value("pose_height");
$copy_qty = get_form_value("copy_qty");
$page_qty = get_form_value("page_qty");
$finishing = get_form_value("finishing");
$machine_washing_qty = get_form_value("machine_washing_qty");
$client_id = get_form_value("client_id");
$budget_name = get_form_value("budget_name");
$shipping = get_form_value("shipping");
$discount_percentage = get_form_value("discount_percentage");
$plus_percentage = get_form_value("plus_percentage");

if (!$mounting) {
    $mounting = 0;
}
if (!$shipping) {
    $shipping = 0;
}
if (!$discount_percentage) {
    $discount_percentage = 0;
}
if (!$plus_percentage) {
    $plus_percentage = 0;
}
 ?>
<div class="container">
  <br>
  <div class="card" style="width: 70rem;">
    <div class="card-header">
      Calcular presupuesto
    </div>
    <div class="card-body">
      <form method="POST" id="first_form">
        @csrf

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Tamaño:') }}</b>
          </label>

          <div class="col-md-6">

            <label class="col-md-6 col-form-label text-md-right">
              Ancho (mm):
            </label>
            <input type="text" size="5" name="pose_width" id="pose_width" value="{{$pose_width}}">
            @error('pose_width')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
            <label class="col-md-6 col-form-label text-md-right">
              Alto (mm):
            </label>
            <input type="text" size="5" name="pose_height" id="pose_height" value="{{$pose_height}}">
            @error('pose_height')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Cantidad de ejemplares:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="copy_qty" id="copy_qty" value="{{$copy_qty}}">
            @error('copy_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Cantidad de páginas:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="page_qty" id="page_qty" value="{{$page_qty}}">
            @error('page_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Acabado:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <select id="finishing" name="finishing">
              <option value=""></option>
              <?php $magazine_calculation = new MagazineCalculation; ?>
              @foreach( $magazine_calculation->finishing_array as $key => $value)
                <option value="{{$key}}"
                  @if($finishing == $key)
                    selected
                  @endif
                >
                  {{$value}}
                </option>
              @endforeach
            </select>
            @error('finishing')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Lavados de máquina:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <select name="machine_washing_qty" id="machine_washing_qty">
              <option value=""></option>
              @foreach(array(1,2,3,4) as $each_machine_washing_qty)
                <option value="{{$each_machine_washing_qty}}"
                  @if($machine_washing_qty == $each_machine_washing_qty)
                    selected
                  @endif
                >
                  {{$each_machine_washing_qty}}
                </option>
              @endforeach
            </select>
            @error('machine_washing_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Cliente:') }}</b>
          </label>

          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              <button onClick="JavaScript:newWindow('/configuration/add_client_popup')">Agregar cliente</button>
            </label>
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
            @error('client_id')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Nombre presupuesto:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="15" name="budget_name" id="budget_name" value="{{$budget_name}}">
            @error('budget_name')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Envío (importe en pesos):') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="shipping" id="shipping" value="{{$shipping}}">
            @error('shipping')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Descuento:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="discount_percentage" id="discount_percentage" value="{{$discount_percentage}}">
            @error('discount_percentage')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Plus:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="plus_percentage" id="plus_percentage" value="{{$plus_percentage}}">
            @error('plus_percentage')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="col-md-6">
          <button type="submit" class="btn btn-primary" name="submit" value="first_form_complete">
            {{ __('Entrar') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
