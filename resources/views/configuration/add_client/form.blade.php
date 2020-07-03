<div class="container">
  <br>
  <div class="card" style="width: 50rem;">
    <div class="card-header">
      Agregar cliente
    </div>
    <div class="card-body">
      <form method="POST">
        @csrf
        <div class="form-group row">
          <label class="col-md-4 col-form-label text-md-right">
            {{ __('Nombre:') }}
          </label>
          <div class="col-md-6">
            <input type="text" name="name" class="form-control">
            @error('name')
              <div class="alert alert-danger">
                {{ $message }}
              </div>
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
