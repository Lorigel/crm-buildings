<x-app-layout>
    <div>
        <form action="{{route('users.handle-import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex">
                <div class="w-1/2">
                    <div class="    ">
                        <x-label for="importFile">{{__('File CSV')}} *</x-label>
                        <x-input type="file" name="importFile" accept=".csv" />
                        @error('importFile')
                            <x-error :error="$message" />
                        @enderror

                        <div class="">
                            <ol>
                                <li>Il file deve includere colonne: nome, cognome, email, username, assegnato_a</li>
                                <li>L'estensione consentita è CSV</li>
                                <li>Peso massimo 1MB</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="w-1/2">
                    <div class="form-group">
                        <x-label for="role" class="block required">{{__('Seleziona ruolo')}} *</x-label>
                        <x-select :options="$roles"  name="role" class="block mt-1 w-full" :value="old('role')" />
                        @error('role')
                            <x-error :error="$message" />
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" id="btnSubmit" class="button-submit">Avvia
                </button>
            </div>
        </form>

        @if(session()->has('status'))
            <div class="alert alert-success">
                {!! session()->get('status') !!}
            </div>
        @endif
    </div>
</x-app-layout>