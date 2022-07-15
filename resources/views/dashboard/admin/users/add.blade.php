<x-app-layout pageName="Register">
          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Panello</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                      <a href="javascript: void(0);">AMSZEROAD</a>
                    </li>
                    <li class="breadcrumb-item active">Nuovo utente</li>
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
        <p>{!! \Session::get('msg') !!}</p>
        @endif
        <form method="POST" action="{{ route('user-add') }}">
            @csrf
            <div class="form-group">
                <x-label for="name" :value="__('Nome *')" />
                <x-input id="name" class="form-control block mt-1 w-full" type="text" name="name" :value="old('name')" />
                @error('name')
                <x-error :error="$message" />
                @enderror
            </div>
            <div class="form-group">
                <x-label for="surname" :value="__('Cognome *')" />
                <x-input id="surname" class="form-control block mt-1 w-full" type="text" name="surname" :value="old('surname')" />
                @error('surname')
                <x-error :error="$message" />
                @enderror
            </div>
            <div class="form-group">
                <x-label for="email" :value="__('Email *')" />
                <x-input id="email" class="form-control block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus />
                @error('email')
                <x-error :error="$message" />
                @enderror
            </div>

            <div class="form-group">
                <x-label for="username" :value="__('Username *')" />
                <x-input id="username" class="form-control block mt-1 w-full" type="text" name="username" :value="old('username')" autocomplete="username" />
                @error('username')
                <x-error :error="$message" />
                @enderror
            </div>

            <div class="form-group">
                <x-label for="role" :value="__('Role *')" />
                <x-select :options="$roles" name="role" class="form-control block mt-1 w-full" :value="old('role')" />
                @error('role')
                <x-error :error="$message" />
                @enderror
            </div>

            <div class="form-group mt-4 d-none">
                <x-label for="assigned_to" :value="__('Riferito da: *')" />
                <x-select name="assigned_to" class="form-control block mt-1 w-full" :value="old('assigned_to')" :options="$assigned_to" />
                @error('assigned_to')
                <x-error :error="$message" />
                @enderror
            </div>

            <x-button class="btn btn-success">{{__('Crea Utente')}}</x-button>
        </form>

</x-app-layout>