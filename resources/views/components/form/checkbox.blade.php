<div class="custom-control custom-control-alternative custom-checkbox">
    <input {{ $attributes }} class="custom-control-input{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" id="checkbox-{{ $name }}" type="checkbox" {{ old($name, $value) ? 'checked' : '' }}>
    <label class="custom-control-label" for="checkbox-{{ $name }}">
        @if ($title)
        <span class="text-muted">{{ $title }}</span>
        @endif

        @if($slot)
        {{ $slot }}
        @endif
    </label>
</div>
@if ($errors->has($name))
    <span class="invalid-feedback" style="display: block;" role="alert">
        <strong>{{ $errors->first($name) }}</strong>
    </span>
@endif
