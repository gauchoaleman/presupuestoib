<div class="card" style="width: 50rem;">
  <div class="card-header">
    Detalle trabajo
  </div>
  <div class="card-body">

    @csrf
    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Papel:') }}</b>
      </label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          Tipo:
        </label>
        <input type="hidden" name="paper_type_id" value="{{$all_input["paper_type_id"]}}">
        {{$paper_type}}
        <label class="col-md-6 col-form-label text-md-right">
          Color:
        </label>
        <input type="hidden" name="paper_color_id" value="{{$all_input["paper_color_id"]}}">
        {{$paper_color}}
        <label class="col-md-6 col-form-label text-md-right">
          Peso:
        </label>
        <input type="hidden" name="weight" value="{{$all_input["weight"]}}">
        {{$all_input["weight"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Ancho (mm):
        </label>
        <input type="hidden" name="pose_width" value="{{$all_input["pose_width"]}}">
        {{$all_input["pose_width"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Alto (mm):
        </label>
        <input type="hidden" name="pose_height" value="{{$all_input["pose_height"]}}">
        {{$all_input["pose_height"]}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Colores:') }}</b>
      </label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          Frente:
        </label>
        <input type="hidden" name="front_color_qty" value="{{$all_input["front_color_qty"]}}">
        {{$all_input["front_color_qty"]}}
        <label class="col-md-6 col-form-label text-md-right">
          Dorso:
        </label>
        <input type="hidden" name="back_color_qty" value="{{$all_input["back_color_qty"]}}">
        {{$all_input["back_color_qty"]}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 1:
        </label>
        <input type="hidden" name="pantone_1" value="{{$all_input["pantone_1"]}}">
        {{$all_input["pantone_1"]}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 2:
        </label>
        <input type="hidden" name="pantone_2" value="{{$all_input["pantone_2"]}}">
        {{$all_input["pantone_2"]}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 3:
        </label>
        <input type="hidden" name="pantone_3" value="{{$all_input["pantone_3"]}}">
        {{$all_input["pantone_3"]}}

      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cantidad de Poses:') }}</b>
      </label>
      <input type="hidden" name="pose_qty" value="{{$all_input["pose_qty"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{ $all_input["pose_qty"] ?? '-' }}
      </div>
    </div>

    <div class="form-group row">*
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
        <b>{{ __('Máquina:') }}</b>
      </label>
      <input type="hidden" name="machine" value="{{$all_input["machine"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["machine"]}}
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
        <b>{{ __('Cantidad de pliegues:') }}</b>
      </label>
      <input type="hidden" name="fold_qty" value="{{$all_input["fold_qty"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{ $all_input["fold_qty"] ?? '' }}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Dificultad troquel:') }}</b>
      </label>
      <input type="hidden" name="punching_difficulty" value="{{$all_input["punching_difficulty"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{ $all_input["punching_difficulty"] ?? '-' }}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Perforar:') }}</b>
      </label>
      <input type="hidden" name="perforate" value="{{$all_input["perforate"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["perforate"] ) Si @else No @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Trazado:') }}</b>
      </label>
      <input type="hidden" name="tracing" value="{{$all_input["tracing"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["tracing"] ) Si @else No @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Laca:') }}</b>
      </label>
      <input type="hidden" name="lac" value="{{$all_input["lac"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $all_input["lac"] ) Si @else No @endif
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
        <b>{{ __('Acabados varios:') }}</b>
      </label>
      <input type="hidden" name="various_finishing" value="{{$all_input["various_finishing"]}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$all_input["various_finishing"]*$result["dollar_price"]}}
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
        {{$all_input["mounting"]*$result["dollar_price"]}}
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
        {{$all_input["shipping"]*$result["dollar_price"]}}
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
        {{$all_input["discount_percentage"]}}
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
        {{$all_input["plus_percentage"]}}
      </div>
    </div>

  </div>
</div>
