<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
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
    
                                                <h4 class="font-size-18 mt-4">Reset Password</h4>
                                                <p class="text-muted">Reset your password to Ecosisma Bonus.</p>
                                            </div>

                                            <div class="p-2 mt-5">
                                                <div class="alert alert-success mb-4" role="alert">
                                                    Enter your Email and instructions will be sent to you!
                                                </div>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group auth-form-group-custom mb-4">
                 <i class="ri-mail-line auti-custom-input-icon"></i>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button  class="btn btn-primary w-md waves-effect waves-light">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
                                             
                                            </div>

                                            <div class="mt-5 text-center">
                                                <p>Don't have an account ? <a href="/register" class="font-weight-medium text-primary">Register here</a> </p>
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
        

        </form>
    </x-auth-card>
</x-guest-layout>
