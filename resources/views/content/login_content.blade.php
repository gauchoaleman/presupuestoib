<div class="container" align="center">
  <br>
  <form method="POST" action="/login">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="user" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Clave:') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>



                                <button type="submit" class="btn btn-primary">
                                    {{ __('Entrar') }}
                                </button>


  </form>
</div>
