<p>{{__('DETTAGLIO')}}</p>

    <div class="form-group">
        <x-label for="amount" :value="__('Importo (€)')" />
        <x-input id="amount" class="form-control block mt-1 w-full js-data-input" type="text" name="amount" :value="old('amount') ?? (isset($contract) ? $contract->amount : '')" data-input />
        <x-error />
    </div>

    <div>
        <p>{{__('Località intervento lavoro pratica')}}</p>
        <div class="form-group">
        <x-label for="address" :value="__('Indirizzo')" />
        <x-input id="address" class="form-control block mt-1 w-full js-data-input" type="text" name="address" :value="old('address') ?? (isset($contract) ? $contract->address : '')" data-input />
        <x-error />
    </div>
    </div>
    <div class="form-group">
        <x-label for="referral" :value="__('Riferimento')" />
        <x-input id="referral" class="form-control block mt-1 w-full js-data-input" type="text" name="referral" :value="old('referral') ?? (isset($contract) ? $contract->referral : '')" data-input />
        <x-error />
    </div>

    <div class="form-group">
        <x-label for="technic" :value="__('Tecnico *')" />
        <x-select id="technic" :options="$technics" name="technic" class="form-control block mt-1 w-full js-data-input" :value="old('technic') ?? (isset($contract) ? $contract->technic : '')" data-input />
        <x-error />
    </div>

    <div class="mt-4">
        <x-label for="company" :value="__('Azienda *')" />
        <x-select id="company" :options="$companies" name="company" class="form-control block mt-1 w-full js-data-input" :value="old('company') ?? (isset($contract) ? $contract->company : '')" data-input />
        <x-error />
    </div>

    @if(Auth::user()->canAddGeneralContractor())
        <div class="mt-4">
            <x-label for="general_contractor" :value="__('General Contractor *')" />
            <x-select id="general_contractor" :options="$general_contractors" name="general_contractor" class="form-control block mt-1 w-full js-data-input" :value="old('general_contractor') ?? (isset($contract) ? $contract->general_contractor : '')" data-input />
            <x-error />
        </div>
    @endif

    <p class="text-lg mb-5 mt-5">{{__('Note')}}</p>
    <textarea name="note" rows="3" class="form-control w-full js-data-input" :value="old('note') ?? (isset($contract) ? $contract->note : '')" data-input></textarea>
