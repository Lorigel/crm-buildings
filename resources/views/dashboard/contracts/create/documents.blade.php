@if(!isset($title) || $title)
    <h2>{{__('Documenti')}}</h2>
@endif
<div data-repeater class="mt-2">
    <template id="data-repeater-clone">
        <div data-repeated-item data-repeater-base-name="documents" style="margin-bottom:30px" class="row flex flex-col md:flex-row lg:items-center flex-wrap py-4 relative mb-5">
            <div class="col-sm-10">
                <div class="w-1/2 form-group">
                    <x-select name="type" id="type" class="form-control js-data-input" :options="$options" />
                    <x-error />
                    <div class="d-none">
                        <x-label for="name" :value="__('Titolo *')" />
                        <x-input id="name" class="block mt-1 w-full js-data-input" type="text" name="name" :value="old('name')" />
                        <x-error />
                    </div>
                </div>
                <div class="w-1/2 form-group">
                    <x-input type="file" accept="application/pdf" name="document" class="form-control js-data-input btn btn-warning" id="document" />
                    <x-error />
                </div>
            </div>

            <div class="col-sm-2">
                <button  style="float:right;" type="button" data-repeater-remove class="btn btn-danger">
                    x
                </button>
            </div>
        </div>
    </template>

    <div data-repeated-items-container>
        @if(isset($documents))
            @php 
                $options = $contract->hasStatus('pending') ? config('document-type.agent') : array_merge(config('document-type.agent'), config('document-type.technic'));
            @endphp

            @foreach($documents as $index=>$document)
            <div data-repeated-item data-repeater-base-name="documents" class="row">
                <div class="col-sm-10">
                    <div class="w-1/2 form-group">
                        <x-select name="documents_{{$index}}_type" id="type" class="form-control js-data-input" :options="$options" :value="$document->type" />
                        <x-error />
                        <div class="{{$document['type'] != 'other' ? 'd-none' : ''}}">
                            <x-label for="name" :value="__('Titolo *')" />
                            <x-input id="name" class="block mt-1 w-full js-data-input" type="text" name="documents_{{$index}}_name" :value="$document->title" />
                            <x-error />
                        </div>
                    </div>
                    <div class="w-1/2 d-flex">
                        <a download href="{{config('app.url') . '/storage/documents/' . $document->pdf}}">{{__('Scarica documento')}}</a>
                        
                        <div class="pl-5">
                            {{__('Modifica documento:')}}
                            <x-input type="file" accept="application/pdf" name="documents_{{$index}}_document" class="js-data-input" id="document" />
                            <x-error />
                        </div>
                    </div>
                </div>

                <div class="col-sm-2">
                    <button  type="button" data-repeater-remove class="btn btn-danger">
                        x
                    </button>
                </div>
            </div>
            @endforeach
        @endif
        </div>

    <div class="flex justify-center my-6">
        <button type="button" data-repeater-add class="btn btn-success uppercase bg-pink-500 text-white flex items-center gap-5 py-1 px-5 rounded-full">Add document</button>
    </div>
</div>  