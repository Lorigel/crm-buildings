<!-- upload other documents for technic user  -->
<form method="POST" data-action="{{ route('contract.technic.documents', ['id' => $contract->id]) }}" data-form="contract-technic-upload-documents" data-contract-form>
    <p>Aggiungi altri documenti</p>
    @include('dashboard.contracts.create.documents', ['documents'=>null, 'title' => false, 'options' => array_merge(config('document-type.agent'), config('document-type.technic'))])
    <p class="js-response"></p>
    <x-button class="btn btn-primary">{{__('Salva')}}</x-button>
</form>