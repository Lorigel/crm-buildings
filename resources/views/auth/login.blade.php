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

                          <h4 class="font-size-18 mt-4">Welcome Back !</h4>
                          <p class="text-muted">Sign in to continue to Ecosisma Bonus.</p>
                        </div>

                        <div class="p-2 mt-5">
                          <form class="form-horizontal" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group auth-form-group-custom mb-4">
                              <i class="ri-user-2-line auti-custom-input-icon"></i>

                              <x-label for="login" :value="__('Email / Username')" />

                              <x-input id="login" class="form-control" type="text" name="login" :value="old('login')" required autofocus />
                            </div>

                            <div class="form-group auth-form-group-custom mb-4">
                              <i class="ri-lock-2-line auti-custom-input-icon"></i>
                              <x-label for="password" :value="__('Password')" />
                              <x-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />

                            </div>

                            <div class="">

                              <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Ricordami') }}</span>
                              </label>
                            </div>



                            <div class="flex items-center justify-end mt-4">

                              <div class="mt-4 text-center">
                                <x-button class="btn btn-primary w-md waves-effect waves-light">
                                  {{ __('Accedi') }}
                                </x-button>
                              </div>

                              <!-- Session Status -->
                              <x-auth-session-status class="my-2 text-center" :status="session('status')" />

                              <!-- Validation Errors -->
                              <x-auth-validation-errors class="my-2 text-center text-danger" :errors="$errors" />

                              @if (Route::has('password.request'))
                              <div class="mt-4 text-center">
                                <a style="margin-top:25px;" class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                  {{ __('Hai dimenticato la password?') }}
                                </a>
                              </div>
                              @endif
                            </div>
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