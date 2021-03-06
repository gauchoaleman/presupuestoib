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
        <input type="hidden" name="paper_type_id" value="{{$paper_type_id}}">
        {{$paper_type}}
        <label class="col-md-6 col-form-label text-md-right">
          Color:
        </label>
        <input type="hidden" name="paper_color_id" value="{{$paper_color_id}}">
        {{$paper_color}}
        <label class="col-md-6 col-form-label text-md-right">
          Peso:
        </label>
        <input type="hidden" name="weight" value="{{$weight}}">
        {{$weight}}
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
        <b>{{ __('Colores:') }}</b>
      </label>

      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          Frente:
        </label>
        <input type="hidden" name="front_color_qty" value="{{$front_color_qty}}">
        {{$front_color_qty}}
        <label class="col-md-6 col-form-label text-md-right">
          Dorso:
        </label>
        <input type="hidden" name="back_color_qty" value="{{$back_color_qty}}">
        {{$back_color_qty}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 1:
        </label>
        <input type="hidden" name="pantone_1" value="{{$pantone_1}}">
        {{$pantone_1}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 2:
        </label>
        <input type="hidden" name="pantone_2" value="{{$pantone_2}}">
        {{$pantone_2}}

        <label class="col-md-6 col-form-label text-md-right">
          Pantone 3:
        </label>
        <input type="hidden" name="pantone_3" value="{{$pantone_3}}">
        {{$pantone_3}}

      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Cantidad de Poses:') }}</b>
      </label>
      <input type="hidden" name="pose_qty" value="{{$pose_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $pose_qty ) {{$pose_qty}} @else - @endif
      </div>
    </div>

    <div class="form-group row">*
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
        <b>{{ __('Máquina frente:') }}</b>
      </label>
      <input type="hidden" name="front_machine" value="{{$front_machine}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$front_machine}}
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Máquina dorso:') }}</b>
      </label>
      <input type="hidden" name="back_machine" value="{{$back_machine}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        {{$back_machine}}
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
        <b>{{ __('Cantidad de pliegues:') }}</b>
      </label>
      <input type="hidden" name="fold_qty" value="{{$fold_qty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $fold_qty ) {{$fold_qty}} @else 0 @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Dificultad troquel:') }}</b>
      </label>
      <input type="hidden" name="punching_difficulty" value="{{$punching_difficulty}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $punching_difficulty ) {{$punching_difficulty}} @else - @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Perforar:') }}</b>
      </label>
      <input type="hidden" name="perforate" value="{{$perforate}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $perforate ) Si @else No @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Trazado:') }}</b>
      </label>
      <input type="hidden" name="tracing" value="{{$tracing}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $tracing ) Si @else No @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Laca:') }}</b>
      </label>
      <input type="hidden" name="lac" value="{{$lac}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $lac ) Si @else No @endif
      </div>
    </div>

    <div class="form-group row">
      <label class="col-md-4 col-form-label text-md-right">
        <b>{{ __('Compilar:') }}</b>
      </label>
      <input type="hidden" name="compile" value="{{$compile}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $compile ) Si @else No @endif
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
        <b>{{ __('Acabados varios:') }}</b>
      </label>
      <input type="hidden" name="various_finishing" value="{{$various_finishing}}">
      <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">
          &nbsp;
        </label>
        @if( $various_finishing ){{$various_finishing}}@else - @endif
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
        @if( $mounting ){{$mounting}}@else - @endif
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
