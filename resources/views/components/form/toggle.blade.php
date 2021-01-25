<div {{ $attributes->merge(['class' => 'flex-wrap align-content-center custom-control custom-control-alternative d-flex justify-content-between pl-0']) }}>
    @if ($title)
    <span class="{{ ($errors->has($name)) ? 'text-warning' : 'text-muted'}}">{{ $title }}</span>
    @endif
    <label class="custom-toggle" for="toggle-{{ $name }}">
        <input {{ $attributes }} class="{{ $errors->has($name) ? ' is-invalid' : ' is-valid' }}" name="{{ $name }}" id="toggle-{{ $name }}" type="checkbox" {{ old($name, $value) ? 'checked' : '' }}>

        <span class="custom-toggle-slider rounded-circle" data-label-off="{{ $labelOff }}" data-label-on="{{ $labelOn }}"></span>
    </label>

    @if($slot)
    {{ $slot }}
    @endif

    @if ($errors->has($name))
        <span class="invalid-feedback" style="display: block;" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
