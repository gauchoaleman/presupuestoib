<?php
$paper_type = get_paper_type($paper_all_input["paper_type_id"]);
?>
<div class="form-group row">
  Colores: {{$paper_all_input["front_color_qty"]}}-{{$paper_all_input["back_color_qty"]}}<br>
  @if(isset($paper_all_input["front_pantone"]))
  Pantone frente<br>
  @endif
  @if(isset($paper_all_input["back_pantone"]))
    Pantone dorso
  @endif
</div>
<div class="form-group row">
  Papel: {{$paper_result["sheet_qty_and_excess"]}} hojas. {{$paper_type}} {{$paper_all_input["weight"]}}gr. {{$paper_result["sheet_size"]["width"]}}x{{$paper_result["sheet_size"]["height"]}}<br>
  cortar a: {{$paper_all_input["leaf_width"]}}x{{$paper_all_input["leaf_height"]}}
</div>
<div class="form-group row">
  Máquina frente: {{$paper_all_input["front_machine"]}}<br>
  Máquina dorso: {{$paper_all_input["back_machine"]}}<br>
</div>
