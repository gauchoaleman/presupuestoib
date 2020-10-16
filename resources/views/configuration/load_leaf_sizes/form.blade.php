<div class="container">
  <br>
  <div class="card" style="width: 50rem;">
    <div class="card-header">
      Agregar tamaños de papeles
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            {{ __('Archivo:') }}
          </label>

          <div class="col-md-6">
            <input type="file" name="file" required class="form-control">
          </div>
          <button type="submit" class="btn btn-primary">
            {{ __('Entrar') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
