<div class="form-group{{ $errors->has($name) ? ' has-danger' : '' }}">
    <div class="input-group input-group-alternative">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="{{ $icon }}"></i></span>
        </div>
        <input {{ $attributes }} class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" type="{{ $type }}" name="{{ $name }}" id="input-{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}">
    </div>
    @if ($errors->has($name))
        <span class="invalid-feedback" style="display: block;" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
