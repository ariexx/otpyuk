      <div class="container mt-5">
          <div class="row">
              <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                  <div class="card card-primary">
                      <div class="card-header">
                          <h4>{{ __('Register') }}</h4>
                      </div>

                      <div class="card-body">
                          <form wire:submit.prevent='registerUser'>
                              @csrf
                              <div class="form-group">
                                  <label for="email">Email</label>
                                  <input id="email" type="email"
                                      class="form-control  @error('email') is-invalid @enderror" tabindex="1" required
                                      autofocus wire:model.defer='email'>
                                  @error('email')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>

                              <div class="form-group">
                                  <div class="d-block">
                                      <label for="password" class="control-label">Password</label>
                                  </div>
                                  <input id="password" type="password"
                                      class="form-control @error('password') is-invalid @enderror" tabindex="2" required
                                      wire:model.defer='password'>
                                  @error('password')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <div class="d-block">
                                      <label for="password" class="control-label">Confirm Password</label>
                                  </div>
                                  <input id="password_confirmation" type="password"
                                      class="form-control @error('password_confirmation') is-invalid @enderror"
                                      tabindex="2" required wire:model.defer='password_confirmation'>
                                  @error('password_confirmation')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                      Register
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
                  <div class="mt-5 text-muted text-center">
                      Sudah punya akun? <a href="{{ route('login') }}">Login Disini</a>
                  </div>
              </div>
          </div>
      </div>
