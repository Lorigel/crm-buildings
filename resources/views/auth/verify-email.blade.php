<x-guest-layout>
    <x-auth-card>
        <p>{{__('Invia email di verifica')}}</p>

        <form method="POST" action="{{ route('account.send-verification-email') }}">
            @csrf
            <div class="mt-4">
                <x-label for="email" :value="__('E-mail *')" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" />
                @error('email')
                    <x-error :error="$message" />
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Invia') }}
                </x-button>
            </div>
        </form>

        @if (\Session::has('message'))
            <p>{!! \Session::get('message') !!}</p>
        @endif
    </x-auth-card>
</x-guest-layout>
