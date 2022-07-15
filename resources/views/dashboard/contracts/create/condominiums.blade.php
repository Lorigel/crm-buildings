<br>
<h2 class="uppercase">{{__('Condomini')}}</h2>
<div data-repeater class="mt-2">
    <template id="data-repeater-clone">
        <div data-repeated-item data-repeater-base-name="condominiums" class="flex flex-col md:flex-row lg:items-center flex-wrap py-4 relative mb-1">
            <div class="w-full pr-16">
                <div class="form-group">
                    <x-label for="name" :value="__('Nome e cognome *')" />
                    <x-input id="name" class="form-control block mt-1 w-full js-data-input" type="text" name="name" :value="old('name')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="postal_code" :value="__('CAP')" />
                    <x-input id="postal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="postal_code" :value="old('postal_code')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="municipio" :value="__('Comune')" />
                    <x-input id="municipio" class="form-control block mt-1 w-full js-data-input" type="text" name="municipio" :value="old('municipio')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="province" :value="__('Province')" />
                    <x-select id="province" :options="config('provinces')" name="province" class="form-control block mt-1 w-full js-data-input" :value="old('province')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="residence" :value="__('Residenza/Via *')" />
                    <x-input id="residence" class="form-control block mt-1 w-full js-data-input" type="text" name="residence" :value="old('residence')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="fiscal_code" :value="__('Codice fiscale *')" />
                    <x-input id="fiscal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="fiscal_code" :value="old('fiscal_code')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="generality" :value="__('Generalità')" />
                    <x-input id="generality" class="form-control block mt-1 w-full js-data-input" type="text" name="generality" :value="old('generality')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="quote" :value="__('Quota mille')" />
                    <x-input id="quote" class="form-control block mt-1 w-full js-data-input" type="text" name="quote" :value="old('quote')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="heating" :value="__('Unità abitativa con riscalamento')" />
                    <x-select id="heating" :options="array('1' => 'Si', 0 => 'No')" name="heating" class="form-control block mt-1 w-full js-data-input" :value="old('heating')" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="note" :value="__('Note')" />
                    <textarea id="note" name="note" rows="3" class="w-full js-data-input" :value="old('note')"></textarea>
                </div>
                <div class="form-group">
                    @php
                        $condominium_documents = config('document-type.condominium');
                    @endphp
                    <h4>{{__('Documenti')}}</h4>
                    <div class="mt-1">
                        <h6>{{__('Aggiungi i documenti necessari')}}</h6>
                        @foreach ($condominium_documents as $document)
                            <p class="mt-3 "><b>{{__($document['name'])}}</b></p>
                            <x-input type="file" accept="application/pdf" name="{{$document['value']}}" class="form-control js-data-input btn btn-warning" id="{{$document['value']}}" />
                        @endforeach
                        <p class="mt-3 mb-2"><b>{{__('Altro')}}</b></p>
                        <div class="d-flex align-items-end">
                            <div class="w-50">
                                <p>{{__('Titolo')}}</p>
                                <x-input id="other-name" class="form-control block mt-1 w-full js-data-input" type="text" name="documents_other-name" :value="old('other-name')" />
                                <x-error />
                            </div>
                            <div class="w-50">
                                <x-input type="file" accept="application/pdf" name="other-file" class="form-control js-data-input btn btn-warning" id="other-file" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="absolute top-7/12 -right-0 flex-shrink-0 inline-flex">
                <button type="button" data-repeater-remove class="text-primary relative w-8 bg-pink-500 text-white px-2 py-1 rounded-full">
                    x
                </button>
            </div>
        </div>
    </template>

    <div data-repeated-items-container>
        @if(isset($condominiums))
            @foreach($condominiums as $condominium)
                <div data-repeated-item data-repeater-base-name="condominiums" class="flex flex-col md:flex-row lg:items-center flex-wrap py-4 relative mb-1">
                <div class="w-full pr-16">
                <div class="form-group">
                    <x-label for="name" :value="__('Nome e cognome *')" />
                    <x-input id="name" class="form-control block mt-1 w-full js-data-input" type="text" name="name" :value="$condominium->name" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="postal_code" :value="__('CAP')" />
                    <x-input id="postal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="postal_code" :value="$condominium->postal_code" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="municipio" :value="__('Comune')" />
                    <x-input id="municipio" class="form-control block mt-1 w-full js-data-input" type="text" name="municipio" :value="$condominium->municipio" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="province" :value="__('Province')" />
                    <x-select id="province" :options="config('provinces')" name="province" class="form-control block mt-1 w-full js-data-input" :value="$condominium->province" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="residence" :value="__('Residenza/Via *')" />
                    <x-input id="residence" class="form-control block mt-1 w-full js-data-input" type="text" name="residence" :value="$condominium->residence" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="fiscal_code" :value="__('Codice fiscale *')" />
                    <x-input id="fiscal_code" class="form-control block mt-1 w-full js-data-input" type="text" name="fiscal_code" :value="$condominium->fiscal_code" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="generality" :value="__('Generalità')" />
                    <x-input id="generality" class="form-control block mt-1 w-full js-data-input" type="text" name="generality" :value="$condominium->generality" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="quote" :value="__('Quota mille')" />
                    <x-input id="quote" class="form-control block mt-1 w-full js-data-input" type="text" name="quote" :value="$condominium->quote" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="heating" :value="__('Unità abitativa con riscalamento')" />
                    <x-select id="heating" :options="array('1' => 'Si', 0 => 'No')" name="heating" class="form-control block mt-1 w-full js-data-input" :value="$condominium->heating" />
                    <x-error />
                </div>
                <div class="form-group">
                    <x-label for="note" :value="__('Note')" />
                    <textarea id="note" name="note" rows="3" class="w-full js-data-input" :value="$condominium->note"></textarea>
                </div>
                @if(isset($condominium->documents))
                    <div class="my-3">
                        <h4>{{__('Documenti caricati')}}</h4>
                        @foreach($condominium->documents as $key=>$document)
                            <div class="d-flex">
                                @if($key == 'other-file')
                                    @php 
                                        $otherName = 'other-name';
                                    @endphp
                                    <p>{{$condominium->documents->$otherName}}: <a href="{{config('app.url') . '/storage/condominiums' . $document}}" download>{{__('Scarica documento')}}</a></p> 
                                @elseif($key != 'other-name')
                                    <p>{{collect(config('document-type.condominium'))->where('value', $key)->first()['name']}}: <a href="{{config('app.url') . '/storage/condominiums' . $document}}" download>{{__('Scarica documento')}}</a></p> 
                                @endif
                            </div>
                        @endforeach
                        <input type="hidden" name="documents" id="documents" class="js-data-input" value="{{json_encode($condominium->documents)}}" />
                    </div>
                @endif
            </div>

            <div class="absolute top-7/12 -right-0 flex-shrink-0 inline-flex">
                <button type="button" data-repeater-remove class="text-primary relative w-8 bg-pink-500 text-white px-2 py-1 rounded-full">
                    x
                </button>
            </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="flex justify-center my-6">
        <button type="button" data-repeater-add class="btn btn-success uppercase bg-pink-500 text-white flex items-center gap-5 py-1 px-5 rounded-full">{{__('Aggiungi soggetto')}}</button>
    </div>
</div>
