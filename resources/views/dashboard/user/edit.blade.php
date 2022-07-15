
<x-app-layout>
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Panello</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">AMSZEROAD</a>
                    </li>
                    <li class="breadcrumb-item active">Modifica Utente</li>
                    </ol>
                </div>
                </div>
            </div>
        </div>
          <!-- end page title -->
          <!-- end row -->
          <div class="row">
            <!-- <a href="{{route('users.import')}}">{{__('Importa utente')}}</a> -->
            <div class="col-sm-8">
                @if (\Session::has('msg'))
                <p class="alert alert-success">{!! \Session::get('msg') !!}</p>
                @endif
            </div>
          </div>
        <div class="col-sm-8">
            @if(!$user->email_verified_at)
                <p>{{__('Questo utente non ha verificato il suo account')}}</p>
            @endif

            <form method="POST" action="{{ route('user.update') }}">
                @csrf

                <input hidden name="user_id" value="{{$user->id}}" />
                <p class="text-lg mb-8 mt-5">{{__('Dati Anagrafici')}}</p>
                <div class="form-group mt-4">
                    <x-label for="business_name" :value="__('Ragione Sociale')" />
                    <x-input id="business_name" class="form-control block mt-1 w-full" type="text" name="business_name" :value="old('business_name') ?? $user->business_name" :disabled="!$user->email_verified_at ? true : false" />
                    @error('business_name')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="name" :value="__('Nome *')" />
                    <x-input id="name" class="form-control block mt-1 w-full" type="text" name="name" :value="old('name') ?? $user->name" :disabled="!$user->email_verified_at ? true : false" />
                    @error('name')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="surname" :value="__('Cognome *')" />
                    <x-input id="surname" class="form-control block mt-1 w-full" type="text" name="surname" :value=" old('surname') ?? $user->surname" :disabled="!$user->email_verified_at ? true : false" />
                    @error('surname')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="address" :value="__('Indirizzo *')" />
                    <x-input id="address" class="form-control block mt-1 w-full" type="text" name="address" :value="old('address') ?? $user->address" :disabled="!$user->email_verified_at ? true : false" />
                    @error('address')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="postal_code" :value="__('CAP *')" />
                    <x-input id="postal_code" class="form-control block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code') ?? $user->postal_code" :disabled="!$user->email_verified_at ? true : false" />
                    @error('postal_code')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="city" :value="__('Città *')" />
                    <x-input id="city" class="form-control block mt-1 w-full" type="text" name="city" :value="old('city') ?? $user->city" :disabled="!$user->email_verified_at ? true : false" />
                    @error('city')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="province" :value="__('Provincia')" />
                    <x-select :options="config('provinces')"  name="province" class="form-control block mt-1 w-full" :value="old('province') ?? $user->province" :disabled="!$user->email_verified_at ? true : false" />
                    @error('province')
                        {!! $message !!}
                    @enderror
                </div>

                <p class="text-lg mb-8 mt-5">{{__('Dati Fiscali')}}</p>
                <div class="form-group mt-4">
                    <x-label for="vat_number" :value="__('Partita IVA')" />
                    <x-input id="vat_number" class="form-control block mt-1 w-full" type="text" name="vat_number" :value="old('vat_number') ?? $user->vat_number" :disabled="!$user->email_verified_at ? true : false" />
                    @error('vat_number')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="fiscal_number" :value="__('Codice Fiscale *')" />
                    <x-input id="fiscal_number" class="form-control block mt-1 w-full" type="text" name="fiscal_number" :value="old('fiscal_number') ?? $user->fiscal_number" :disabled="!$user->email_verified_at ? true : false" />
                    @error('fiscal_number')
                        {!! $message !!}
                    @enderror
                </div>

                <p class="text-lg mb-8 mt-5">{{__('Recapiti')}}</p>
                <div class="form-group mt-4">
                    <x-label for="phone_number" :value="__('Telefono')" />
                    <x-input id="phone_number" class="form-control block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number') ?? $user->phone_number" :disabled="!$user->email_verified_at ? true : false" />
                    @error('phone_number')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="mobile_number" :value="__('Cellulare *')" />
                    <x-input id="mobile_number" class="form-control block mt-1 w-full" type="text" name="mobile_number" :value="old('mobile_number') ?? $user->mobile_number" :disabled="!$user->email_verified_at ? true : false" />
                    @error('mobile_number')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="pec" :value="__('Pec')" />
                    <x-input id="pec" class="form-control block mt-1 w-full" type="text" name="pec" :value="old('pec') ?? $user->pec" :disabled="!$user->email_verified_at ? true : false" />
                    @error('pec')
                        {!! $message !!}
                    @enderror
                </div>

                <!-- only admin and master can edit position and assigned to -->
                @if($can_edit_assigned_to)
                    <p class="text-lg mb-8 mt-5">{{__('Pozicione *')}}</p>
                    <div class="form-group mt-4">
                        <x-select :options="$roles"  name="role" class="form-control block mt-1 w-full" :value="old('role') ?? $user->role" :disabled="!$user->email_verified_at ? true : false" />
                        @error('role')
                            <x-error :error="$message" />
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <x-label for="assigned_to_name" :value="__('Riferito da (nome):')" />
                        <x-input id="assigned_to_name" class="form-control block mt-1 w-full" type="text" name="assigned_to_name" :value="old('assigned_to_name') ?? $user->assigned_to_name" :disabled="!$user->email_verified_at ? true : false" />
                        @error('assigned_to_name')
                            <x-error :error="$message" />
                        @enderror
                    </div>

                    @if($user->email_verified_at)
                        <div class="form-group mt-4">
                            <x-label for="assigned_to" :value="__('Riferito da (utente):')" />
                            <x-select name="assigned_to" class="form-control block mt-1 w-full" :value="old('assigned_to') ?? $user->assigned_to" :options="$assigned_to" />
                            @error('assigned_to')
                                <x-error :error="$message" />
                            @enderror
                        </div>
                    @endif
                @endif

                @if(Auth::user()->canAddProfitToGeneralContractors() && $user->hasRole('general-contractor'))
                    <div class="form-group mt-4">
                        <x-label for="profit" :value="__('Percentuale di profitto *')" />
                        <div class="d-flex align-items-center">
                            <x-input id="profit" class="form-control block mt-1 w-full" type="number" step="0.01" name="profit" :value="old('profit') ?? $user->profit" :disabled="!$user->email_verified_at ? true : false" />%
                        </div>
                        @error('profit')
                            <x-error :error="$message" />
                        @enderror
                    </div>
                @endif


                <p class="text-lg mb-8 mt-5">{{__('Accesso al portale')}}</p>
                <div class="form-group mt-4">
                    <x-label for="username" :value="__('Username *')" />
                    <x-input id="username" class="form-control block mt-1 w-full" type="text" name="username" :value="old('username') ?? $user->username" :disabled="!$user->email_verified_at ? true : false" />
                    @error('username')
                        {!! $message !!}
                    @enderror
                </div>
                <div class="form-group mt-4">
                    <x-label for="password" :value="__('Password')" />
                    <x-input id="password" class="form-control block mt-1 w-full" type="password" name="password" :disabled="!$user->email_verified_at ? true : false" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group  mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-input id="password_confirmation" class="form-control block mt-1 w-full" type="password" name="password_confirmation" :disabled="!$user->email_verified_at ? true : false" />
                </div>
                @error('password')
                        {!! $message !!}
                @enderror
                <div class="form-group">
                    <p class="text-lg  mt-5">{{__('Note')}}</p>
                    <textarea name="note" rows="3" class="form-control w-full" @if(!$user->email_verified_at) disabled @endif>{{old('note') ?? $user->note}}</textarea>
                </div>
                <div>
                    <p class="text-lg mb-5 mt-5">{{__('Newsletter')}}</p>
                    <p>{{__('Desideri rievere periodicamnente le nostre offerte e le novita?')}}</p>
                    <p>{{__('Potrai sempre cambiare questa opzione dal tuo pannello di gestione.')}}</p>
                    <input type="checkbox" id="newsletter" name="newsletter" @if($subscribed || old('newsletter')) checked @endif @if(!$user->email_verified_at) disabled @endif /> {{__('Iscrivi alla newsletter')}}
                </div>

                <!-- user activation -->
                @if($can_edit_assigned_to)
                    <div class="form-group mt-10">
                        <input class="" type="checkbox" id="is_active" name="is_active" @if($user->account_verified_at || old('is_active')) checked @endif @if(!$user->email_verified_at) disabled @endif /> {{__('Attiva utente')}}
                    </div>
                @endif
                <br>
                <x-button class="btn btn-success" :disabled="!$user->email_verified_at ? true : false">{{__('Salva')}}</x-button>
            </form>

            @if (\Session::has(''))
                <p>{!! \Session::get('msg') !!}</p>
            @endif
        </div>
</x-app-layout>
