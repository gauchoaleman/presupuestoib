<form method="POST">
@csrf
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{ __('Valor:') }}</label>

    <div class="col-md-6">
        <input type="text" name="amount" required class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">
                {{ __('Entrar') }}
    </button>
</div>
</form>
