<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if (!$hideLabel)
    <label class="form-control-label" for="input-{{ $name }}">
        {{ $title }}
        @if($slot)
        {{ $slot }}
        @endif
    </label>
    @else
    @if($slot)
    {{ $slot }}
    @endif
    @endif
    <input {{ $attributes }} type="{{ $type }}" name="{{ $name }}" id="input-{{ $name }}" class="form-control form-control-alternative{{ $errors->has($name) ? ' is-invalid' : '' }}" placeholder="{{ __($placeholder) }}" value="{{ old($name, $value) }}">

    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first($name) }}
        </span>
    @endif
</div>
