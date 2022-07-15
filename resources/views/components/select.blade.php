@props(['options' => null, 'value' => null, 'disabled' => false])

<select  {!! $attributes->merge(['class' => 'w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}  value="{{$value}}" {{ $disabled ? 'disabled' : '' }} >
    <option value="" >... Select one option</option>
    @if($options)
        @foreach($options as $option)
            @php 
                $option_value = $option['value'] ?? $option
            @endphp
            <option value="{{$option_value}}" @if($value == $option_value) selected @endif >{{$option['name'] ?? $option}}</option>
        @endforeach
    @endif
</select>