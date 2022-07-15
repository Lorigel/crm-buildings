<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </a>
    </x-slot>

    <body class="auth-body-bg">
      
      <div>
        <div class="container-fluid p-0">
          <div class="row no-gutters">
            <div class="col-lg-6">
              <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                <div class="w-100">
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <div>
                        <div class="text-center">
                          <div>
                            <a href="index.html" class="logo"><img src="{{ asset('images/logo-dark.jpg') }}" height="50" alt="logo"></a>
                          </div>

                          <h4 class="font-size-18 mt-4">Benvenuto!</h4>
                          <p class="text-muted">Per favore imposta la tua nuova password</p>
                        </div>

                        <div class="p-2 mt-5">
                             <form method="POST" action="{{ route('password.set') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <!-- Password -->
            <div class="form-group">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="form-control block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="form-control  block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <div class="flex items-center justify-end mt-4">
                <x-button class="btn btn-primary">
                    {{ __('Imposta la Password') }}
                </x-button>
            </div>
        </form>
                         



                           
                          </form>
                        </div>

                        <div class="mt-5 text-center">
                          <p>{{__('Non sei un utente? ')}} <a href="/register">{{__('Registrati')}}</a></p>
                          <p>© 2020 Ecosisma Bonus. Crafted with <i class="mdi mdi-heart text-danger"></i> .</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="authentication-bg">
                <div class="bg-overlay"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </x-auth-card>
</x-guest-layout>




<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

       
    </x-auth-card>
</x-guest-layout>
