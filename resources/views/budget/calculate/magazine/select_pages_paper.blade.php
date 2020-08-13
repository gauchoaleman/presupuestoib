<?php
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

for( $i=0;$i<=$page_qty/4;$i++ ){
  //By foil
  echo "job_data[$i]['paper_type_id']";
  $job_data[$i]["paper_type_id"] = get_form_array_value("job_data",$i,"paper_type_id");
  $job_data[$i]["paper_color_id"] = get_form_value("job_data[$i]['paper_color_id']");
  $job_data[$i]["weight"] = get_form_value("job_data[$i]['weight']");

  //By foil_front & foil_back
  $job_data[$i]["front_color_qty"] = get_form_value("job_data[$i]['front_color_qty']");
  $job_data[$i]["front_pantone"] = get_form_value("job_data[$i]['front_pantone']");
  $job_data[$i]["front_machine"] = get_form_value("job_data[$i]['front_machine']");
  $job_data[$i]["back_color_qty"] = get_form_value("job_data[$i]['back_color_qty']");
  $job_data[$i]["back_pantone"] = get_form_value("job_data[$i]['back_pantone']");
  $job_data[$i]["back_machine"] = get_form_value("job_data[$i]['back_machine']");
}
echo "Post:";
print_r($_POST);
echo "Job data:";
print_r($job_data);
/*
if (!$front_color_qty) {
    $front_color_qty = 0;
}
if (!$back_color_qty) {
    $back_color_qty = 0;
}
//Color blanco x defecto
if ($paper_type_id && !$paper_color_id) {
    $paper_color_id = 1;
}*/
?>
<div class="container">
  <br>
  <form method="POST" action="/budget/calculate/magazine/select_pages_paper">
    @csrf
    @include('budget.calculate.magazine.select_pages_paper.job_detail_card')
    <br>
    <div class="card" style="width: 70rem;">
      <div class="card-header">
        Configurar páginas
      </div>
      <div class="card-body">
        @for ($i = 0; $i <= $page_qty/4; $i++)
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            <b>
              @if($i==0)
                Tapa/Contratapa y retiros:
              @else
                Folio {{$i}}, Páginas {{$i*2-1}}, {{$i*2}}, {{$page_qty-2*($i-1)-1}}, {{$page_qty-2*($i-1)}} :
              @endif
            </b>
          </label>

          <div class="col-md-6">
            <label class="col-md-6 col-form-label text-md-right">
              Tipo:
            </label>
            job_data_paper_type_id:{{$job_data[$i]['paper_type_id'] }}
            <select id="paper_type_id" name="job_data[{{$i}}][paper_type_id]" onchange="this.form.submit()">
              <option value=""></option>
              @foreach(get_paper_types() as $paper_type)
                <option value="{{$paper_type->id}}"
                  @if($job_data[$i]['paper_type_id'] == $paper_type->id )
                    selected
                  @endif
                >
                  {{$paper_type->name}}
                </option>
              @endforeach
            </select>
            @error($job_data[$i]["paper_type_id"])
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
