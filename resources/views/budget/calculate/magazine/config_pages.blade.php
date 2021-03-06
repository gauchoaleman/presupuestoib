<?php
use App\Classes\Calculation\Magazine\MagazineCalculation;
$pose_width = get_form_value("pose_width");
$pose_height = get_form_value("pose_height");
$copy_qty = get_form_value("copy_qty");
$page_qty = get_form_value("page_qty");
$finishing = get_form_value("finishing");
$machine_washing_qty = get_form_value("machine_washing_qty");
$mounting = get_form_value("mounting");
$client_id = get_form_value("client_id");
$client_name = get_client_name($client_id);
$budget_name = get_form_value("budget_name");
$shipping = get_form_value("shipping");
$discount_percentage = get_form_value("discount_percentage");
$plus_percentage = get_form_value("plus_percentage");

for( $foil_number=0;$foil_number<=$page_qty/4;$foil_number++ ){
  //By foil
  $job_data[$foil_number]["paper_type_id"] = get_form_sub_array_value("job_data",$foil_number,"paper_type_id");
  $job_data[$foil_number]["paper_color_id"] = get_form_sub_array_value("job_data",$foil_number,"paper_color_id");
  $job_data[$foil_number]["weight"] = get_form_sub_array_value("job_data",$foil_number,"weight");
  //Color blanco x defecto
  if ($job_data[$foil_number]["paper_type_id"] && !$job_data[$foil_number]["paper_color_id"])
      $job_data[$foil_number]["paper_color_id"] = 1;
  //By foil_front & foil_back
  $job_data[$foil_number]["front_color_qty"] = get_form_sub_array_value("job_data",$foil_number,"front_color_qty");
  $job_data[$foil_number]["front_pantone"] = get_form_sub_array_value("job_data",$foil_number,"front_pantone");
  $job_data[$foil_number]["front_machine"] = get_form_sub_array_value("job_data",$foil_number,"front_machine");
  $job_data[$foil_number]["back_color_qty"] = get_form_sub_array_value("job_data",$foil_number,"back_color_qty");
  $job_data[$foil_number]["back_pantone"] = get_form_sub_array_value("job_data",$foil_number,"back_pantone");
  $job_data[$foil_number]["back_machine"] = get_form_sub_array_value("job_data",$foil_number,"back_machine");
}
/*
if (!$front_color_qty) {
    $front_color_qty = 0;
}
if (!$back_color_qty) {
    $back_color_qty = 0;
}
*/
?>
<div class="container">
  <br>
  <form method="POST" action="/budget/calculate/magazine/config_pages">
    @csrf
    @include('budget.calculate.magazine.config_pages.job_detail_card')
    <br>
    <div id="pages_config"></div>
    <div class="card" style="width: 70rem;">
      <div class="card-header">
        Configurar páginas
      </div>
      <div class="card-body">
        @for ($foil_number = 0; $foil_number <= $page_qty/4; $foil_number++)
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>
              @if($foil_number==0)
                Tapa/Contratapa y retiros:
              @else
                Folio {{$foil_number}}, Páginas {{$foil_number*2-1}}, {{$foil_number*2}}, {{$page_qty-2*($foil_number-1)-1}}, {{$page_qty-2*($foil_number-1)}} :
              @endif
            </b>
          </label>

          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              Tipo:
            </label>
            <select id="paper_type_id" name="job_data[{{$foil_number}}][paper_type_id]" onchange="this.form.submit()">
              <option value=""></option>
              @foreach(get_paper_types() as $paper_type)
                <option value="{{$paper_type->id}}"
                  @if($job_data[$foil_number]['paper_type_id'] == $paper_type->id )
                    selected
                  @endif
                >
                  {{$paper_type->name}}
                </option>
              @endforeach
            </select>
            @error($job_data[$foil_number]["paper_type_id"])
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Color:
            </label>
            <select id="paper_color_id" name="job_data[{{$foil_number}}][paper_color_id]" onchange="this.form.submit()">
              <option value=""></option>
              @if(isset($job_data[$foil_number]["paper_type_id"]))
                @foreach(get_paper_colors($job_data[$foil_number]["paper_type_id"]) as $paper_color)
                  <option value="{{$paper_color->id}}"
                    @if($job_data[$foil_number]["paper_color_id"]==$paper_color->id)
                      selected
                    @endif
                  >
                    {{$paper_color->name}}
                  </option>
                @endforeach
              @endif
            </select>
            @error($job_data[$foil_number]["paper_color_id"])
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Peso:
            </label>
            <select id="weight" name="job_data[{{$foil_number}}][weight]">
              <option value=""></option>
              @if(isset($job_data[$foil_number]["paper_type_id"]) && isset($job_data[$foil_number]["paper_color_id"]))
                @foreach(get_paper_weights($job_data[$foil_number]["paper_type_id"],$job_data[$foil_number]["paper_color_id"]) as $paper_weight)
                  <option value="{{$paper_weight->weight}}"
                    @if($job_data[$foil_number]["weight"] == $paper_weight->weight)
                      selected
                    @endif
                  >
                    {{$paper_weight->weight}}
                  </option>
                @endforeach
              @endif
            </select>
            @error($job_data[$foil_number]["weight"])
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Ctd de colores frente:
            </label>
            <select name="job_data[{{$foil_number}}][front_color_qty]" id="back_color_qty">
              @foreach(array(0,1,2,3,4,5) as $each_color_qty)
                <option value="{{$each_color_qty}}"
                  @if($job_data[$foil_number]["front_color_qty"] == $each_color_qty)
                    selected
                  @endif
                >
                  {{$each_color_qty}}
                </option>
              @endforeach
            </select>
            @error($job_data[$foil_number]["front_color_qty"])
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Pantone frente:
            </label>
            <input type="checkbox" name="job_data[{{$foil_number}}][front_pantone]" value="1" id="front_pantone"
              @if($job_data[$foil_number]["front_pantone"] == "1")
              checked
              @endif
            >

            <label class="col-md-6 col-form-label text-md-right">
              Máquina frente:
            </label>
            <select name="job_data[{{$foil_number}}][front_machine]" id="front_machine">
              <?php $magazine_calculation = new MagazineCalculation; ?>
              <option value=""></option>
              @foreach($magazine_calculation->machine_list as $each_machine)
                <option value="{{$each_machine}}"
                  @if($job_data[$foil_number]["front_machine"] == $each_machine)
                    selected
                  @endif
                >
                  {{$each_machine}}
                </option>
              @endforeach
            </select>

            <label class="col-md-6 col-form-label text-md-right">
              Ctd de colores dorso:
            </label>
            <select name="job_data[{{$foil_number}}][back_color_qty]" id="back_color_qty">
              @foreach(array(0,1,2,3,4,5) as $each_color_qty)
                <option value="{{$each_color_qty}}"
                  @if($job_data[$foil_number]["back_color_qty"] == $each_color_qty)
                    selected
                  @endif
                >
                  {{$each_color_qty}}
                </option>
              @endforeach
            </select>
            @error($job_data[$foil_number]["back_color_qty"])
              <div class="alert alert-danger">
                {{ $message }}
              </div>
            @enderror

            <label class="col-md-6 col-form-label text-md-right">
              Pantone dorso:
            </label>
            <input type="checkbox" name="job_data[{{$foil_number}}][back_pantone]" value="1" id="back_pantone"
              @if($job_data[$foil_number]["back_pantone"] == "1")
              checked
              @endif
            >

            <label class="col-md-6 col-form-label text-md-right">
              Máquina dorso:
            </label>
            <select name="job_data[{{$foil_number}}][back_machine]" id="back_machine">
              <?php $magazine_calculation = new MagazineCalculation; ?>
              <option value=""></option>
              @foreach($magazine_calculation->machine_list as $each_machine)
                <option value="{{$each_machine}}"
                  @if($job_data[$foil_number]["back_machine"] == $each_machine)
                    selected
                  @endif
                >
                  {{$each_machine}}
                </option>
              @endforeach
            </select>

          </div>
        </div>
        @endfor
        <div class="col-md-6">
          <button type="submit" class="btn btn-primary">
            {{ __('Entrar') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  var elmnt = document.getElementById("pages_config").scrollIntoView();
</script>
