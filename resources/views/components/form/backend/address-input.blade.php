<x-form.backend.location :model="$address" :prefix="$prefix"/>

@if ($locationOnly)
<input type="hidden" name="address[{{ $prefix }}][title]"        value="{{ $address->title }}" />
<input type="hidden" name="address[{{ $prefix }}][phone]"        value="{{ $address->phone }}" />
<input type="hidden" name="address[{{ $prefix }}][line_1]"       value="{{ $address->line_1 }}" />
<input type="hidden" name="address[{{ $prefix }}][line_2]"       value="{{ $address->line_2 }}" />
<input type="hidden" name="address[{{ $prefix }}][zip]"          value="{{ $address->zip }}" />
<input type="hidden" name="address[{{ $prefix }}][description]"  value="{{ $address->description }}" />
@else
<x-form.input :name="'address[' . $prefix . '][title]'" :placeholder="__('basic.inputs.address.title')" :value="$address->title">
    {{ __('basic.inputs.address.title') }}
</x-form.input>

<x-form.input :name="'address[' . $prefix . '][phone]'" :placeholder="__('basic.inputs.address.phone')" :value="$address->phone">
    {{ __('basic.inputs.address.phone') }}
</x-form.input>

<x-form.input :name="'address[' . $prefix . '][line_1]'" :placeholder="__('basic.inputs.address.line_1')" :value="$address->line_1">
    {{ __('basic.inputs.address.line_1') }}
</x-form.input>

<x-form.input :name="'address[' . $prefix . '][line_2]'" :placeholder="__('basic.inputs.address.line_2')" :value="$address->line_2">
    {{ __('basic.inputs.address.line_2') }}
</x-form.input>

<x-form.input :name="'address[' . $prefix . '][zip]'" :placeholder="__('basic.inputs.address.zip')" :value="$address->zip">
    {{ __('basic.inputs.address.zip') }}
</x-form.input>

<x-form.textarea :name="'address[' . $prefix . '][description]'" :placeholder="__('basic.inputs.address.details')" :value="$address->description">
    {{ __('basic.inputs.address.details') }}
</x-form.input>
@endif
