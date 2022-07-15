<x-guest-layout pageName="Register">
  
  <x-auth-card>
    <div class="home-btn d-none d-sm-block">
      <a href="index.html"><i class="mdi mdi-home-variant h2 text-white"></i></a>
    </div>
    <div>
      <div class="container-fluid p-0" style=" background: linear-gradient(rgba(255,255,255,.8), rgba(255,255,255,.8)),   url('images/bg.png'); background-repeat: no-repeat;background-size: cover;">
        <div class="row no-gutters">
          <div class="col-lg-8 offset-lg-2">
            <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
              <div class="w-100">
                <div class="row justify-content-center">
                  <div class="col-lg-9">
                    <div>
                      <div class="text-center">
                        <div>
                          <a href="index.html" class="logo"><img src="{{ asset('images/logo-dark.jpg') }}" height="50" alt="logo"></a>
                        </div>
                      
                        <h4 class="hide-reg-s font-size-18 mt-4">Register account</h4>
                        <p class="hide-reg-s text-muted">Get your free Ecosisma Bonus account now.</p>
                      </div>

                      <div class="p-2 mt-5">
                          @if (\Session::has('msg'))
   <p class="alert alert-success">{!! \Session::get('msg') !!}</p>

  @endif
                        <form id="register-form" method="POST" action="{{route('register')}}" enctype='multipart/form-data' class="hide-reg-s">
                          @csrf
                          <p class="text-lg mb-8 mt-5">{{__('Dati Anagrafici')}}</p>

                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-at-line auti-custom-input-icon"></i>

                            <x-label for="business_name" :value="__('Ragione Sociale')" />
                            <x-input id="business_name" placeholder="Ragione sociale" class="form-control" type="text" name="business_name" :value="old('business_name')" />
                            @error('business_name')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-search-line auti-custom-input-icon"></i>
                            <x-label for="name" :value="__('Nome *')" />
                            <x-input id="name" placeholder="John" class="form-control" type="text" name="name" :value="old('name')" />
                            @error('name')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-search-line auti-custom-input-icon"></i>
                            <x-label for="surname" :value="__('Cognome *')" />
                            <x-input id="surname" placeholder="Doe" class="form-control" type="text" name="surname" :value=" old('surname')" />
                            @error('surname')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-search-line auti-custom-input-icon"></i>
                            <x-label for="birthday" :value="__('Data di nascita *')" />
                            <x-input id="birthday" placeholder="mm/dd/yy" class="form-control" type="date" name="birthday" :value=" old('birthday')" />
                            @error('birthday')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="address" :value="__('Indirizzo *')" />
                            <x-input id="address" placeholder="Strada 42" class="form-control" type="text" name="address" :value="old('address')" />
                            @error('address')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="postal_code" :value="__('CAP *')" />
                            <x-input id="postal_code" placeholder="xxxxx" class="form-control" type="text" name="postal_code" :value="old('postal_code')" />
                            @error('postal_code')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="city" :value="__('Città *')" />
                            <x-input id="city" placeholder="Roma" class="form-control" type="text" name="city" :value="old('city')" />
                            @error('city')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="province" :value="__('Provincia')" />
                            <x-select :options="config('provinces')" name="province" class="form-control" :value="old('province')" />
                            @error('province')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="size" :value="__('Taglia tuta sportiva *')" />
                            <x-select :options="array(
                              [
                                'value' => 's',
                                'name' => 'S'
                              ],
                              [
                                'value' => 'm',
                                'name' => 'M'
                              ],
                              [
                                'value' => 'l',
                                'name' => 'L'
                              ],
                              [
                                'value' => 'xxl',
                                'name' => 'XXL'
                              ],
                               [
                                'value' => 'xxxl',
                                'name' => 'XXXL'
                              ]
                              )" name="size" class="form-control" :value="old('size')" />
                            @error('size')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-location-line auti-custom-input-icon"></i>
                            <x-label for="image" :value="__('Immagine')" />
                            <x-input id="image" class="form-control" type="file" name="image" accept="image/png, image/jpeg" />
                            @error('image')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <p class="text-lg mb-8 mt-5">{{__('Dati Fiscali')}}</p>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="vat_number" :value="__('Partita IVA')" />
                            <x-input id="vat_number" class="form-control" type="text" name="vat_number" :value="old('vat_number')" />
                            @error('vat_number')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="fiscal_number" :value="__('Codice Fiscale *')" />
                            <x-input id="fiscal_number" class="form-control" type="text" name="fiscal_number" :value="old('fiscal_number')" />
                            @error('fiscal_number')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <p class="text-lg mb-8 mt-5">{{__('Dati bankari')}}</p>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="bank" :value="__('Banca e Filiale *')" />
                            <x-input id="bank" class="form-control" type="text" name="bank" :value="old('bank')" />
                            @error('bank')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="iban" :value="__('IBAN *')" />
                            <x-input id="iban" class="form-control" type="text" name="iban" :value="old('iban')" />
                            @error('iban')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="bic" :value="__('BIC')" />
                            <x-input id="bic" class="form-control" type="text" name="bic" :value="old('bic')" />
                            @error('bic')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <p class="text-lg mb-8 mt-5">{{__('Recapiti')}}</p>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-phone-line auti-custom-input-icon"></i>
                            <x-label for="phone_number" :value="__('Telefono')" />
                            <x-input id="phone_number" class="form-control" type="text" name="phone_number" :value="old('phone_number')" />
                            @error('phone_number')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-phone-line auti-custom-input-icon"></i>
                            <x-label for="mobile_number" :value="__('Cellulare *')" />
                            <x-input id="mobile_number" class="form-control" type="text" name="mobile_number" :value="old('mobile_number')" />
                            @error('mobile_number')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-mail-line auti-custom-input-icon"></i>
                            <x-label for="email" :value="__('Email *')" />
                            <x-input id="email" class="form-control" placeholder="someone@example.com" type="email" name="email" :value="old('email')" />
                            @error('email')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-mail-line auti-custom-input-icon"></i>
                            <x-label for="company_email" :value="__('Mail aziendale')" />
                            <x-input id="company_email" class="form-control" placeholder="someone@example.com" type="company_email" name="company_email" :value="old('company_email')" />
                            @error('company_email')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <style>
                            @media (min-width: 640px) {
                              .sm\:max-w-md {
                                max-width: 100% !important;
                              }

                              .authentication-page-content {
                                height: 100% !important;
                              }
                            }
                          </style>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-hashtag auti-custom-input-icon"></i>
                            <x-label for="pec" :value="__('Pec')" />
                            <x-input id="pec" class="form-control" type="text" name="pec" :value="old('pec')" />
                            @error('pec')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <p class="text-lg mb-8 mt-5">{{__('Pozicione *')}}</p>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-line auti-custom-input-icon"></i>
                            <x-label for="role" :value="__('Ruolo / Livello*')" />
                            <x-select :options="$roles" name="role" class="form-control" x :value="old('role')" />
                            @error('role')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <!-- <div class="mt-4 d-none">
                              <x-label for="assigned_to" :value="__('Presentato da: *')" />
                              <x-select name="assigned_to" class="block mt-1 w-full" :value="old('assigned_to')" />
                              @error('assigned_to')
                                  <x-error :error="$message" />
                              @enderror
                          </div> -->

                          <div class="form-group auth-form-group-custom mb-4 d-none">
                            <i class="ri-user-line auti-custom-input-icon"></i>
                            <x-label for="assigned_to_name" :value="__('Riferito da: *')" />
                            <x-input id="assigned_to_name" class="form-control" type="text" name="assigned_to_name" :value="old('assigned_to_name')" />
                            @error('assigned_to_name')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <p class="text-lg mb-8 mt-5">{{__('Accesso al portale')}}</p>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-user-line auti-custom-input-icon"></i>
                            <x-label for="username" :value="__('Username *')" />
                            <x-input id="username" class="form-control" type="text" name="username" :value="old('username')" autocomplete="username" />
                            @error('username')
                            <x-error :error="$message" />
                            @enderror
                          </div>
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-passport-line auti-custom-input-icon"></i>
                            <x-label for="password" :value="__('Password *')" />
                            <x-input id="password" class="form-control" type="password" name="password" autocomplete="new-password" :value="old('password')" />
                          </div>

                          <!-- Confirm Password -->
                          <div class="form-group auth-form-group-custom mb-4">
                            <i class="ri-passport-line auti-custom-input-icon"></i>
                            <x-label for="password_confirmation" :value="__('Confirm Password *')" />
                            <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" autocomplete="new-password" :value="old('password_confirmation')" />
                          </div>
                          @error('password')
                          <x-error :error="$message" />
                          @enderror

                          <p class="text-3xl md:text-4xl font-medium mb-2">{{__('Note')}}</p>
                          <textarea name="note" id="note" rows="3" class="form-control">{{ old('note') }}</textarea>

                          <div class="mt-4">
                            <p>{{__('INFORMATIVA PER IL TRATTAMENTO DEI DATI PERSONALI ai sensi dell’art. 13 del Regolamento UE n. 2016/679 – GDPR (tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali)')}}</p>
                            <div>
                              <input type="checkbox" id="gdpr" name="gdpr" {{ old('gdpr') == 'on' ? 'checked' : '' }} /> {{__("Autorizzo al trattamento dei dati nei modi e secondo le finalita' descritte nell'informativa sopra riportata")}}
                            </div>
                            @error('gdpr')
                            <x-error :error="$message" />
                            @enderror
                          </div>

                          <div class="flex items-center justify-end mt-4">
                            <x-button class="btn btn-primary w-md waves-effect waves-light">
                              {{ __('Register') }}
                            </x-button>
                          </div>
                        </form>
                      </div>
                    
                    </div>

                    <div class="hide-reg-s mt-5 text-center">
                      <p>Already have an account ? <a href="/login" class="font-weight-medium text-primary"> Login</a> </p>
                      <p>© 2020 Ecosisma Bonus. Crafted with <i class="mdi mdi-heart text-danger"></i> .</p>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
     @if (\Session::has('msg'))
   <script>

 
      var x = document.getElementsByClassName("hide-reg-s");
       for (var i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
   
setTimeout(function () {
    window.open('/login', '_self');
}, 10000);

</script>
@endif
  </x-auth-card>

</x-guest-layout>