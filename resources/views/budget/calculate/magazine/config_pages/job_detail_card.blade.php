<?php use App\Classes\Calculation\Magazine\MagazineCalculation; ?>
<div class="card" style="width: 50rem;">
  <div class="card-header">
    Detalle trabajo
  </div>
  <div class="card-body">

    @csrf
    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Tamaño:') }}</b>
      </label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          Ancho (mm):
        </label>
        <input type="hidden" name="pose_width" value="{{$pose_width}}">
        {{$pose_width}}
        <label class="col-md-6 col-form-label text-md-right">
          Alto (mm):
        </label>
        <input type="hidden" name="pose_height" value="{{$pose_height}}">
        {{$pose_height}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cantidad de ejemplares:') }}</b>
      </label>
      <input type="hidden" name="copy_qty" value="{{$copy_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$copy_qty}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cantidad de páginas:') }}</b>
      </label>
      <input type="hidden" name="page_qty" value="{{$page_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$page_qty}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Acabado:') }}</b>
      </label>
      <input type="hidden" name="finishing" value="{{$finishing}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        <?php $magazine_calculation = new MagazineCalculation; ?>
        {{$magazine_calculation->finishing_array[$finishing]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Lavados de máquina:') }}</b>
      </label>
      <input type="hidden" name="machine_washing_qty" value="{{$machine_washing_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $machine_washing_qty ){{$machine_washing_qty}}@else - @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Montaje:') }}</b>
      </label>
      <input type="hidden" name="mounting" value="{{$mounting}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        <?php $magazine_calculation = new MagazineCalculation; ?>
        {{$magazine_calculation->mounting_array[$mounting]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cliente:') }}</b>
      </label>
      <input type="hidden" name="client_id" value="{{$client_id}}">
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
      <input type="hidden" name="budget_name" value="{{$budget_name}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$budget_name}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Envío:') }}</b>
      </label>
      <input type="hidden" name="shipping" value="{{$shipping}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
          @if( $shipping ){{$shipping}}@else - @endif
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Descuento:') }}</b>
      </label>
      <input type="hidden" name="discount_percentage" value="{{$discount_percentage}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $discount_percentage ){{$discount_percentage}}@else - @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Plus:') }}</b>
      </label>
      <input type="hidden" name="plus_percentage" value="{{$plus_percentage}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $plus_percentage ){{$plus_percentage}}@else - @endif
      </div>
    </div>

  </div>
</div>
