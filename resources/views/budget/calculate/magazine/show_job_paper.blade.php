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
?>
<div class="container">
  <br>
  <div style="font-size: 30px;">
    <div class="card" style="width: 50rem;">
      <div class="card-header">
        Hoja de trabajo
      </div>
      <div class="card-body">
        <div class="form-group row">
          <?php $date = new DateTime();?>
          Fecha: {{$date->format('d/m/Y')}}
        </div>
        <div class="form-group row">
          Cliente: {{$client_name}}
        </div>
        <div class="form-group row">
          Trabajo: {{$all_input["budget_name"]}}
        </div>
        <div class="form-group row">
          Cantidad: {{$all_input["copy_qty"]}}
        </div>
        <div class="form-group row">
          Formato: {{$all_input["pose_width"]}}x{{$all_input["pose_height"]}}
        </div>
        <div class="form-group row">
          <?php $magazine_calculation = new MagazineCalculation; ?>
          Acabado: {{$magazine_calculation->finishing_array[$finishing]}}
        </div>

        @foreach( $result["paper_info"] as $paper_index => $paper )
        <input type="hidden" name="paper_data[{{$paper_index}}]" value="{{$all_input["paper_data"][$paper_index]}}">
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
            @include('budget.calculate.magazine.show_job_paper.paper_detail',
            array("paper_all_input" => $all_input["unique_papers"][$paper_index],"paper_result" => $paper))
          </div>
        </div>
        @endforeach


      </div>
    </div>
  </div>
</div>
<script>
  print();
</script>
