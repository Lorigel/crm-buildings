<x-app-layout pageName="Contract">
    <form method="POST" data-action="{{ route('contract.update', ['id' => $contract->id]) }}" data-form="contract-edit" data-contract-form>
        @csrf
        @include('dashboard.contracts.create.client-data', ['contract' => $contract])

        @include('dashboard.contracts.create.products', ['contract' => $contract, 'products' => $products])

        @include('dashboard.contracts.create.details', ['technics' => $technics, 'companies' => $companies, 'general_contractors' => $general_contractors, 'contract' => $contract])

        @include('dashboard.contracts.create.condominiums', ['condominiums' => json_decode($contract->condominiums)])

        @include('dashboard.contracts.create.documents', ['options' => config('document-type.agent')])
        <br>

        @if($invoice)
            <div>
                <p class="mt-4 mb-2">Fattura</p>
                <p>
                    <a download href="{{config('app.url') . '/storage/invoices' . $invoice->pdf}}">{{__('Scarica fattura')}}</a>
                </p>
            </div>
        @endif

        @if(Auth::user()->canApproveContract())
            {{-- approve agent docs --}}
            @if($contract->hasStatus('pending'))
                <div class="form-group mt-10">
                    {{__('Conferma pratica')}}
                    <input class="js-input" data-input type="radio" name="approved" value="1" @if($contract->hasStatus('open') || old('approved') === 1) checked @endif>Si
                    <input class="js-input" data-input type="radio" name="approved" value="0" @if($contract->status=='cancelled' ||  old('approved') === 0) checked @endif>No
                </div>
            @endif
            {{-- approve technic docs --}}
            @if($contract->hasStatus('review'))
                <div class="form-group mt-10">
                    {{__('Conferma i documenti')}} <span>(se approvato, l'azienda può caricare la fattura)</span>
                    <div>
                        <input class="js-input" data-input type="radio" name="reviewed" value="1" @if($contract->hasStatus('in_approval') || old('approved') === 1) checked @endif>Si
                        <input class="js-input" data-input type="radio" name="reviewed" value="0" @if($contract->status=='cancelled' ||  old('approved') === 0) checked @endif>No
                    </div>
                </div>
            @endif
            {{-- approve invoice and set contract in working status --}}
            @if($contract->hasStatus('in_approval') && $invoice)
                <div class="form-group mt-10">
                    {{__('Conferma fattura')}} <span>(se approvato, praticha è impostato in stato di lavorazione. Non dimenticare di controllare l'importo di questo contratto)</span>
                    <div>
                        <input class="js-input" data-input type="radio" name="processing" value="1" @if($contract->hasStatus('processing') || old('processing') === 1) checked @endif>Si
                        <input class="js-input" data-input type="radio" name="processing" value="0" @if($contract->status=='cancelled' ||  old('processing') === 0) checked @endif>No
                    </div>
                </div>
            @endif
            {{-- finish contract --}}
            @if($contract->hasStatus('processing'))
                <div class="form-group mt-10">
                    {{__('Praticha e finito?')}} <span></span>
                    <div>
                        <input class="js-input" data-input type="checkbox" id="finished" name="finished" {{ old('finished') == 'on' ? 'checked' : '' }} /> {{__("SI")}}
                    </div>
                </div>
            @endif
        @endif

        <br>
        <hr><br>
        <p class="js-response"></p>
        <x-button class="btn btn-primary">{{__('Salva')}}</x-button>
    </form>
</x-app-layout>