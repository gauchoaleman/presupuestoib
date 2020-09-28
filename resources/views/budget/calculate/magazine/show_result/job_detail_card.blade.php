<div class="card" style="width: 50rem;">
  <div class="card-header">
    Detalle trabajo
  </div>
  <div class="card-body">

    @csrf

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cantidad de ejemplares:') }}</b>
      </label>
      <input type="hidden" name="copy_qty" value="{{$all_input["copy_qty"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["copy_qty"]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Lavados de máquina:') }}</b>
      </label>
      <input type="hidden" name="machine_washing_qty" value="{{$all_input["machine_washing_qty"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["machine_washing_qty"]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cliente:') }}</b>
      </label>
      <input type="hidden" name="client_id" value="{{$all_input["client_id"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$client_name}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Nombre presupuesto:') }}</b>
      </label>
      <input type="hidden" name="budget_name" value="{{$all_input["budget_name"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["budget_name"]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Montaje:') }}</b>
      </label>
      <input type="hidden" name="mounting" value="{{$all_input["mounting"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["mounting"]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Envío:') }}</b>
      </label>
      <input type="hidden" name="shipping" value="{{$all_input["shipping"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["shipping"] ){{$all_input["shipping"]*$result["dollar_price"]}}@else - @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Descuento:') }}</b>
      </label>
      <input type="hidden" name="discount_percentage" value="{{$all_input["discount_percentage"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["discount_percentage"] ){{$all_input["discount_percentage"]*$result["dollar_price"]}}@else - @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Plus:') }}</b>
      </label>
      <input type="hidden" name="plus_percentage" value="{{$all_input["plus_percentage"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["plus_percentage"] ){{$all_input["plus_percentage"]*$result["dollar_price"]}}@else - @endif
      </div>
    </div>

  </div>
</div>
