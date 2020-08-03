<?php
$paper_type_id = get_form_value("paper_type_id");
$paper_color_id = get_form_value("paper_color_id");
$weight = get_form_value("weight");
$pose_width = get_form_value("pose_width");
$pose_height = get_form_value("pose_height");
$front_color_qty = get_form_value("front_color_qty");
$back_color_qty = get_form_value("back_color_qty");
$pantone_1 = get_form_value("pantone_1");
$pantone_2 = get_form_value("pantone_2");
$pantone_3 = get_form_value("pantone_3");
$pose_qty = get_form_value("pose_qty");
$copy_qty = get_form_value("copy_qty");
$machine = get_form_value("machine");
$machine_washing_qty = get_form_value("machine_washing_qty");
$fold_qty = get_form_value("fold_qty");
$punching_difficulty = get_form_value("punching_difficulty");
$perforate = get_form_value("perforate");
$tracing = get_form_value("tracing");
$lac = get_form_value("lac");
$client_id = get_form_value("client_id");
$budget_name = get_form_value("budget_name");
$various_finishing = get_form_value("various_finishing");
$mounting = get_form_value("mounting");
$shipping = get_form_value("shipping");
$discount_percentage = get_form_value("discount_percentage");
$plus_percentage = get_form_value("plus_percentage");

if (!$front_color_qty) {
    $front_color_qty = 0;
}
if (!$back_color_qty) {
    $back_color_qty = 0;
}
if ($paper_type_id && !$paper_color_id) {
    $paper_color_id = 1;
}   //Color blanco x defecto
if (!$fold_qty) {
    $fold_qty = 0;
}

if (!$various_finishing) {
    $various_finishing = 0;
}
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
      <form method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Papel:') }}</b>
          </label>

          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              Tipo:
            </label>
            <select id="paper_type_id" name="paper_type_id" onchange="this.form.submit()">
              <option value=""></option>
              @foreach(get_paper_types() as $paper_type)
                <option value="{{$paper_type->id}}"
                  @if($paper_type_id == $paper_type->id )
                    selected
                  @endif
                >
                  {{$paper_type->name}}
                </option>
              @endforeach
            </select>
            @error('paper_type_id')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Color:
            </label>
            <select id="paper_color_id" name="paper_color_id" onchange="this.form.submit()">
              <option value=""></option>
              @if(isset($paper_type_id))
                @foreach(get_paper_colors($paper_type_id) as $paper_color)
                  <option value="{{$paper_color->id}}"
                    @if($paper_color_id==$paper_color->id)
                      selected
                    @endif
                  >
                    {{$paper_color->name}}
                  </option>
                @endforeach
              @endif
            </select>
            @error('paper_color_id')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Peso:
            </label>
            <select id="weight" name="weight">
              <option value=""></option>
              @if(isset($paper_type_id) && isset($paper_color_id))
                @foreach(get_paper_weights($paper_type_id,$paper_color_id) as $paper_weight)
                  <option value="{{$paper_weight->weight}}"
                    @if($weight == $paper_weight->weight)
                      selected
                    @endif
                  >
                    {{$paper_weight->weight}}
                  </option>
                @endforeach
              @endif
            </select>
            @error('weight')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

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
            <b>{{ __('Colores:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              Frente:
            </label>
            <input type="text" size="5" name="front_color_qty" id="front_color_qty" value="{{$front_color_qty}}">
            @error('front_color_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
            <label class="col-md-6 col-form-label text-md-right">
              Dorso:
            </label>
            <input type="text" size="5" name="back_color_qty" id="back_color_qty" value="{{$back_color_qty}}">
            @error('back_color_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Pantone 1:
            </label>
            <input type="text" size="5" name="pantone_1" id="pantone_1" value="{{$pantone_1}}">
            @error('pantone_1')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Pantone 2:
            </label>
            <input type="text" size="5" name="pantone_2" id="pantone_2" value="{{$pantone_2}}">
            @error('pantone_2')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Pantone 3:
            </label>
            <input type="text" size="5" name="pantone_3" id="pantone_3" value="{{$pantone_3}}">
            @error('pantone_3')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Cantidad de Poses:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="pose_qty" id="pose_qty" value="{{$pose_qty}}">
            @error('pose_qty')
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
            <b>{{ __('Máquina:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <select id="machine" name="machine" id="machine">
              <option value=""></option>
              @foreach(array("Adast","GTO52","GTO46") as $each_machine)
                <option value="{{$each_machine}}"
                  @if($machine == $each_machine)
                    selected
                  @endif
                >
                  {{$each_machine}}
                </option>
              @endforeach
            </select>
            @error('machine')
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
            <b>{{ __('Cantidad de pliegues:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="fold_qty" id="fold_qty" value="{{$fold_qty}}">
            @error('fold_qty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Dificultad troquel:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <select name="punching_difficulty" id="punching_difficulty">
              <option value=""></option>
              @foreach(array(1,2,3,4) as $each_punching_difficulty)
                <option value="{{$each_punching_difficulty}}"
                  @if($punching_difficulty == $each_punching_difficulty)
                    selected
                  @endif
                >
                  {{$each_punching_difficulty}}
                </option>
              @endforeach
            </select>
            @error('punching_difficulty')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Perforar:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="checkbox" name="perforate" value="1" id="perforate"
              @if($perforate == "1")
              checked
              @endif
            >
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Trazado:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="checkbox" name="tracing" value="1" id="tracing"
              @if($tracing == "1")
              checked
              @endif
            >
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Laca:') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="checkbox" name="lac" value="1" id="lac"
              @if($lac == "1")
                checked
              @endif
            >
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Cliente:') }}</b>
          </label>

          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              <a href="/configuration/add_client">Agregar cliente</a>
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
            <b>{{ __('Acabados varios (importe en pesos):') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="various_finishing" id="various_finishing" value="{{$various_finishing}}">
            @error('various_finishing')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Montaje (importe en pesos):') }}</b>
          </label>
          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              &nbsp;
            </label>
            <input type="text" size="5" name="mounting" id="mounting" value="{{$mounting}}">
            @error('mounting')
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
          <button type="submit" class="btn btn-primary">
            {{ __('Entrar') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
