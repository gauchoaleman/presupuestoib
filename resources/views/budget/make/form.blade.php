<?php
$paper_type_id = request()->get('paper_type_id')?request()->get('paper_type_id'):request()->old('paper_type_id');
$paper_color_id = request()->get('paper_color_id')?request()->get('paper_color_id'):request()->old('paper_color_id');
$weight = request()->get('weight')?request()->get('weight'):request()->old('weight');
$width = request()->get('width')?request()->get('width'):request()->old('width');
$height = request()->get('height')?request()->get('height'):request()->old('height');
 ?>
<div class="container">

<div class="card" style="width: 50rem;">
    <div class="card-header">Calcular presupuesto</div>
    <div class="card-body">

<form method="POST">
@csrf
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Papel:') }}</label>

    <div class="col-md-6">
        <label class="col-md-6 col-form-label text-md-right">Tipo:</label>

        <select id="paper_type_id" name="paper_type_id" onchange="this.form.submit()">
          <option value=""></option>
          @foreach(get_paper_types() as $paper_type)
            <option value="{{$paper_type->id}}"
              @if($paper_type_id == $paper_type->id )
              selected
              @endif>{{$paper_type->name}}</option>
          @endforeach
        </select>
        @error('paper_type_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label class="col-md-6 col-form-label text-md-right">Color:</label>
        <select id="paper_color_id" name="paper_color_id" onchange="this.form.submit()">
          <option value=""></option>
          @if(isset($paper_type_id))
            @foreach(get_paper_colors($paper_type_id) as $paper_color)
              <option value="{{$paper_color->id}}"
                @if($paper_color_id==$paper_color->id)
                selected
                @endif>{{$paper_color->name}}

              </option>
            @endforeach
          @endif
        </select>
        @error('paper_color_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label class="col-md-6 col-form-label text-md-right">Peso:</label>
        <select id="weight" name="weight">
          <option value=""></option>
          @if(isset($paper_type_id) && isset($paper_color_id))
            @foreach(get_paper_weights($paper_type_id,$paper_color_id) as $paper_weight)
              <option value="{{$paper_weight->weight}}"
                @if($weight == $paper_weight->weight)
                selected
                @endif>

                {{$paper_weight->weight}}
              </option>
            @endforeach
          @endif
        </select>
        @error('weight')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label class="col-md-6 col-form-label text-md-right">Ancho (mm):</label>
        <input type="text" size="5" name="width" value="{{$width}}">
        @error('width')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="col-md-6 col-form-label text-md-right">Alto (mm):</label>
        <input type="text" size="5" name="height" value="{{$height}}">
        @error('height')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

  <div class="col-md-6">
        <button type="submit" class="btn btn-primary">
                {{ __('Entrar') }}
    </button>
  </div>
</div>
</form>

</div>
</div>
</div>

<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
  $('.dynamic').change(function(){
    if($(this).val() != '')
    {
      var select = $(this).attr("id");
      var value = $(this).val();
      var dependent = $(this).data('dependent');
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{route('budget/make.fetch')}}",
        method: "POST",
        data: {select:select, value:value, _token:_token, dependent:dependent},
        success:function(result)
        {
          $('#'+dependent).html(result);
        }
      })
    }
  });
});
</script>
