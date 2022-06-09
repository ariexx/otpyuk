      <div class="container mt-5">
          <div class="row">
              <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                  <div class="card card-primary">
                      <div class="card-header">
                          <h4>Login</h4>
                      </div>

                      <div class="card-body">
                          <form wire:submit.prevent='login'>
                              @csrf
                              <div class="form-group">
                                  <label for="email">Email</label>
                                  <input id="email" type="email"
                                      class="form-control @error('email') is-invalid @enderror" tabindex="1"
                                      wire:model.defer='email' required autofocus>
                                  @error('email')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>

                              <div class="form-group">
                                  <div class="d-block">
                                      <label for="password" class="control-label">Password</label>
                                      <div class="float-right">
                                          <a href="{{ route('password.request') }}" class="text-small">
                                              Forgot Password?
                                          </a>
                                      </div>
                                  </div>
                                  <input id="password" type="password"
                                      class="form-control @error('password') is-invalid @enderror" tabindex="2"
                                      wire:model.defer='password' required>
                                  @error('password')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>

                              <div class="form-group">
                                  <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" tabindex="3" id="remember"
                                          wire:model.defer='remember'>
                                      <label class="custom-control-label" for="remember">Remember Me</label>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                      Login
                                  </button>
                              </div>
                          </form>

                      </div>
                  </div>
                  <div class="mt-5 text-muted text-center">
                      Belum punya akun? <a href="{{ route('register') }}">Create One</a>
                  </div>
              </div>
          </div>
      </div>
