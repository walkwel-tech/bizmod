<div class=" custom-control-alternative custom-checkbox">
    <input {{ $attributes }} class="{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}"
        id="radio-{{ $name }}-{{ $value }}" value="{{$value}}" type="radio" {{ ($checked==$value )? 'checked' : '' }}>

    <label class="" for="radio-{{ $name }}-{{ $value }}">
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
