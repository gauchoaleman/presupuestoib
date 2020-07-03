<?php
$paper_type_id = get_form_value("paper_type_id");
$paper_color_id = get_form_value("paper_color_id");
$weight = get_form_value("weight");
$width = get_form_value("width");
$height = get_form_value("height");
$front_color_qty = get_form_value("front_color_qty");
$back_color_qty = get_form_value("back_color_qty");
$pose_qty = get_form_value("pose_qty");
$copy_qty = get_form_value("copy_qty");
$machine = get_form_value("machine");
$fold_qty = get_form_value("fold_qty");
$punching_difficulty = get_form_value("punching_difficulty");
$perforate = get_form_value("perforate");
$lac = get_form_value("lac");
$client_id = get_form_value("client_id");
$budget_name = get_form_value("budget_name");
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
if (!$discount_percentage) {
    $discount_percentage = 0;
}
if (!$plus_percentage) {
    $plus_percentage = 0;
}
 ?>
<div class="container"><br>
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
            <input type="text" size="5" name="width" id="width" value="{{$width}}">
            @error('width')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror
            <label class="col-md-6 col-form-label text-md-right">
              Alto (mm):
            </label>
            <input type="text" size="5" name="height" value="{{$height}}">
            @error('height')
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
            <select id="punching_difficulty" name="punching_difficulty" id="punching_difficulty">
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
