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
              @if(isset($_POST["paper_type_id"]) && $_POST["paper_type_id"]==$paper_type->id)
              selected
              @endif>{{$paper_type->name}}</option>
          @endforeach
        </select>
        @error('type')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <label class="col-md-6 col-form-label text-md-right">Color:</label>
        <select id="paper_color_id" name="paper_color_id" onchange="this.form.submit()">
          <option value=""></option>
          @if(isset($_POST["paper_type_id"]))
            @foreach(get_paper_colors($_POST["paper_type_id"]) as $paper_color)
              <option value="{{$paper_color->id}}">
                @if(isset($_POST["paper_color_id"]) && $_POST["paper_color_id"]==$paper_color->id)
                selected
                @endif>{{$paper_color->name}}
              </option>
            @endforeach
          @endif
        </select>
        @error
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