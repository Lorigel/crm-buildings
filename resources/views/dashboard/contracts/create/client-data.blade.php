
<div>
    <div class="form-group">
        <x-label for="client_name" :value="__('Nome*')" />
        <x-input class="form-control block mt-1 w-full js-data-input" type="text" name="client_name" :value="old('client_name') ?? (isset($contract) ? $contract->client_name : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_surname" :value="__('Cognome*')" />
        <x-input class="form-control block mt-1 w-full js-data-input" type="text" name="client_surname" :value="old('client_surname') ?? (isset($contract) ? $contract->client_surname : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_company_name" :value="__('Ragione sociale')" />
        <x-input id="client_company_name" class="form-control block mt-1 w-full js-data-input" type="text" name="client_company_name" :value="old('client_company_name') ?? (isset($contract) ? $contract->client_company_name : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_creation_date" :value="__('Data Costituzione /Data di nascita')" />
        <x-input id="client_creation_date" class="form-control block mt-1 w-full js-data-input" type="date" name="client_creation_date" :value="old('client_creation_date') ?? (isset($contract) ? $contract->client_creation_date : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_legal_form" :value="__('Forma Giuridica *')" />
        <x-select :options="$legal_forms" name="client_legal_form" id="client_legal_form" class="form-control block mt-1 w-full js-data-input" :value="old('client_legal_form') ?? (isset($contract) ? $contract->client_legal_form : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_representive" :value="__('Legale Rappresentante')" />
        <x-input id="client_representive" class="form-control block mt-1 w-full js-data-input" type="text" name="client_representive" :value="old('client_representive') ?? (isset($contract) ? $contract->client_representive : '')" data-input />
        <x-error />
    </div>
    <div  class="form-group">
        <x-label for="client_administrator_fiscal_code" :value="__('CF Amministratore')" />
        <x-input id="client_administrator_fiscal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="client_administrator_fiscal_code" :value="old('client_administrator_fiscal_code') ?? (isset($contract) ? $contract->client_administrator_fiscal_code : '')" data-input />
       <x-error />  
    </div>
    <div  class="form-group">
        <x-label for="client_fiscal_code" :value="__('Codice Fiscale *')" />
        <x-input id="client_fiscal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="client_fiscal_code" :value="old('client_fiscal_code') ?? (isset($contract) ? $contract->client_fiscal_code : '')" data-input />
       <x-error />  
    </div>
    <div  class="form-group">
        <x-label for="client_vat_number" :value="__('P.IVA')" />
        <x-input id="client_vat_number" class="form-control block mt-1 w-full js-data-input" type="text" name="client_vat_number" :value="old('client_vat_number') ?? (isset($contract) ? $contract->client_vat_number : '')" data-input />
        <x-error />
    </div>
    <div  class="form-group">
        <x-label for="client_address" :value="__('Indirizzo Sede Legale / Residenza')" />
        <x-input id="client_address" class="form-control block mt-1 w-full js-data-input" type="text" name="client_address" :value="old('client_address') ?? (isset($contract) ? $contract->client_address : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_postal_code" :value="__('Cap Sede Legale / Residenza')" />
        <x-input id="client_postal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="client_postal_code" :value="old('client_postal_code') ?? (isset($contract) ? $contract->client_postal_code : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_city" :value="__('Citta\' Sede Legale / Residenza')" />
        <x-input id="client_city" class="form-control block mt-1 w-full js-data-input" type="text" name="client_city" :value="old('client_city') ?? (isset($contract) ? $contract->client_city : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_province" :value="__('Provincia Sede Legale / Residenza')" />
        <x-select :options="config('provinces')" name="client_province" class="form-control block mt-1 w-full js-data-input" :value="old('client_province') ?? (isset($contract) ? $contract->client_province : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_phone_number" :value="__('Telefono')" />
        <x-input id="client_phone_number" class="form-control block mt-1 w-full js-data-input" type="text" name="client_phone_number" :value="old('client_phone_number') ?? (isset($contract) ? $contract->client_phone_number : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_mobile_number" :value="__('Cellulare')" />
        <x-input id="client_mobile_number" class="form-control block mt-1 w-full js-data-input" type="text" name="client_mobile_number" :value="old('client_mobile_number') ?? (isset($contract) ? $contract->client_mobile_number : '')" data-input />
        <x-error />
    </div>
    <div class="form-group">
        <x-label for="client_email" :value="__('Email *')" />
        <x-input id="client_email" class="form-control block mt-1 w-full js-data-input" type="text" name="client_email" :value="old('client_email') ?? (isset($contract) ? $contract->client_email : '')" data-input />
        <x-error />
    </div>
</div>