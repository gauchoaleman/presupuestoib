<?php
$paper_type = get_paper_type($all_input["paper_type_id"]);
$paper_color = get_paper_color($all_input["paper_color_id"]);
$client_name = get_client_name($all_input["client_id"]);
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
          Colores: {{$all_input["front_color_qty"]}}-{{$all_input["back_color_qty"]}}
          @if($all_input["pantone_1"]||$all_input["pantone_2"]||$all_input["pantone_3"])Pantone: {{$all_input["pantone_1"]}} {{$all_input["pantone_2"]}} {{$all_input["pantone_3"]}}@endif
        </div>
        <div class="form-group row">
          Papel: {{$result["sheet_qty_and_excess"]}} hojas. {{$paper_type}} {{$all_input["weight"]}}gr. {{$result["sheet_size"]["width"]}}x{{$result["sheet_size"]["height"]}}<br>
          cortar a: {{$all_input["leaf_width"]}}x{{$all_input["leaf_height"]}}
        </div>
        <div class="form-group row">
          Máquina frente: {{$all_input["front_machine"]}}
        </div>
        <div class="form-group row">
          Máquina dorso: {{$all_input["back_machine"]}}
        </div>
        @if( $all_input["fold_qty"] || $all_input["punching_difficulty"] || $all_input["perforate"] || $all_input["tracing"] || $all_input["lac"] )
          <div class="form-group row">
            Acabado: @if($all_input["fold_qty"])Plegado @endif @if($all_input["punching_difficulty"])Troquelado @endif @if($all_input["perforate"])Perforado @endif @if($all_input["tracing"])Trazado @endif @if($all_input["lac"])Laca @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
<script>
  print();
</script>
