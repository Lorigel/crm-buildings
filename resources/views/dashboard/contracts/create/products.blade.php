<p>{{__('Prodotto')}}</p>
<div class="form-group">
    <x-label for="product" :value="__('PRODOTTO DI INTERESSE *')" />
    <x-select :options="$products" name="product" id="product" class="form-control block mt-1 w-full js-data-input" :value="old('product') ?? (isset($contract) ? $contract->product : '')" data-input />
    <x-error />
</div>