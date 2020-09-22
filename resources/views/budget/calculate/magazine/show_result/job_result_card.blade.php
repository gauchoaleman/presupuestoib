<?php
  use App\Classes\Calculation\Common\CommonCalculation;
?>

<div class="card" style="width: 70rem;">
  <div class="card-header">
    Resultado
  </div>
  <div class="card-body">

    @if( $all_input["machine_washing_qty"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Lavados de máquina:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["washing_machine_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["mounting"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Montaje:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($all_input["mounting"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Acabado:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($all_input["finishing"]*$result["dollar_price"],2)}}
      </div>
    </div>

    @if( $all_input["shipping"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Envío:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($all_input["shipping"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $result["subtotal"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Subtotal:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["subtotal"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["discount_percentage"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Descuento:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["discount_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    @if( $all_input["plus_percentage"] )
      <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right">
          <b>{{ __('Plus:') }}</b>
        </label>
        <div class="col-md-6">
          <label class="col-md-6 col-form-label text-md-right">
            &nbsp;
          </label>
          ${{number_format($result["plus_price"]*$result["dollar_price"],2)}}
        </div>
      </div>
    @endif

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Total:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($result["total"]*$result["dollar_price"],0)}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Valor dólar:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($result["dollar_price"],2)}}
      </div>
    </div>

    <div class="col-md-6">
      <button type="submit" class="btn btn-primary" name="button_action" value="show_job_paper">
        {{ __('Ver hoja encargo') }}
      </button>
    </div>

  </div>
</div>
