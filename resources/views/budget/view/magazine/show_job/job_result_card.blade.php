<?php
  use App\Classes\Calculation\Common\CommonCalculation;
?>

<div class="card" style="width: 70rem;">
  <div class="card-header">
    Resultado
  </div>
  <div class="card-body">

    @foreach( $result["paper_info"] as $paper_index => $paper )
    <div class="card" style="width: 65rem;">
      <div class="card-header">
        @foreach($all_input["unique_papers"][$paper_index]["foil_list"] as $foil_number)
          @if($foil_number==0)
            <b>Tapa/Contratapa y retiros:</b><br>
          @else
            <b>Folio {{$foil_number}}, Páginas {{$foil_number*2-1}}, {{$foil_number*2}}, {{$all_input["page_qty"]-2*($foil_number-1)-1}}, {{$all_input["page_qty"]-2*($foil_number-1)}}:</b><br>
          @endif
        @endforeach
      </div>
      <div class="card-body">
        <b>Tipo de papel:</b> {{get_paper_type($all_input["unique_papers"][$paper_index]["paper_type_id"])}}<br>
        <b>Color:</b> {{get_paper_color($all_input["unique_papers"][$paper_index]["paper_color_id"])}}<br>
        <b>Peso:</b> {{$all_input["unique_papers"][$paper_index]["weight"]}}<br>
        @include('budget.calculate.magazine.show_result.job_result_card.paper_detail',
        array("paper_all_input" => $all_input["unique_papers"][$paper_index],"paper_result" => $paper))
      </div>
    </div>
    @endforeach

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


    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Montaje:') }}</b>
      </label>
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        ${{number_format($result["mounting"]*$result["dollar_price"],2)}}
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
        ${{number_format($result["finishing"]*$result["dollar_price"],2)}}
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
