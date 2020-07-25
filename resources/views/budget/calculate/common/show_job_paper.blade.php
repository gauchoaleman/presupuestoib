<?php
$paper_type = get_paper_type($paper_type_id);
$paper_color = get_paper_color($paper_color_id);
$client_name = get_client_name($client_id);
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
          Trabajo: {{$budget_name}}
        </div>
        <div class="form-group row">
          Cantidad: {{$copy_qty}}
        </div>
        <div class="form-group row">
          Formato: {{$pose_width}}x{{$pose_height}}
        </div>
        <div class="form-group row">
          Colores: {{$front_color_qty}}-{{$back_color_qty}} @if($pantone_1||$pantone_2||$pantone_3)Pantone: {{$pantone_1}} {{$pantone_2}} {{$pantone_3}}@endif
        </div>
        <div class="form-group row">
          Papel: {{$sheet_qty_and_excess}} hojas. {{$paper_type}} {{$weight}}gr. {{$sheet_size["width"]}}x{{$sheet_size["height"]}}<br>
          cortar a: {{$leaf_width}}x{{$leaf_height}}
        </div>
        <div class="form-group row">
          Máquina: {{$machine}}
        </div>
        @if( $fold_qty || $punching_difficulty || $perforate || $tracing || $lac )
          <div class="form-group row">
            Acabado: @if($fold_qty)Plegado, @endif @if($punching_difficulty)Troquelado, @endif @if($perforate)Perforado, @endif @if($tracing)Trazado, @endif @if($lac)Laca @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
<script>
  print();
</script>
