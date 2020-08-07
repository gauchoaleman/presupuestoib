<?php
$paper_type_id = get_form_value("paper_type_id");
$paper_color_id = get_form_value("paper_color_id");
$weight = get_form_value("weight");
$front_color_qty = get_form_value("front_color_qty");
$back_color_qty = get_form_value("back_color_qty");
$pantone_1 = get_form_value("pantone_1");
$pantone_2 = get_form_value("pantone_2");
$pantone_3 = get_form_value("pantone_3");
$machine = get_form_value("machine");
$machine_washing_qty = get_form_value("machine_washing_qty");

if (!$front_color_qty) {
    $front_color_qty = 0;
}
if (!$back_color_qty) {
    $back_color_qty = 0;
}
//Color blanco x defecto
if ($paper_type_id && !$paper_color_id) {
    $paper_color_id = 1;
}
?>
<div class="container">
  <br>
  <div class="card" style="width: 70rem;">
    <div class="card-header">
      Configurar páginas
    </div>
    <div class="card-body">
      <form method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>{{ __('Tapa/Contratapa y retiros:') }}</b>
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
