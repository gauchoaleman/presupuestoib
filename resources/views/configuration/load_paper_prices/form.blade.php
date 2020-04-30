<form method="POST" enctype="multipart/form-data">
@csrf
<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Archivo:') }}</label>

    <div class="col-md-6">
        <input type="file" name="file" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">
                {{ __('Entrar') }}
    </button>
</div>
</form>
