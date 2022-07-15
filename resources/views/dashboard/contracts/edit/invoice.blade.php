<form method="POST" data-action="{{ route('contract.invoice.upload', ['id' => $contract->id]) }}" data-form="contract-upload-invoice" data-contract-form>
    <p>Aggiungi fattura</p>
    <p>(PDF allowed)</p>
    <div class="w-1/2 form-group">
        <input type="file" name="invoice" id="invoice" accept="application/pdf" class="js-data-input" />
        <x-error />
    </div>
    <p class="js-response"></p>
    <x-button class="btn btn-primary">{{__('Aggiungi')}}</x-button>
</form>