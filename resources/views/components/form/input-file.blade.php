<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label class="form-control-label" for="input-name">{{ $title }}</label>
    <div class="custom-file">

        <input {{ $attributes }} type="file" class="custom-file-input" name="{{ $name }}" id="input-{{ $name }}" lang="en">
        <label class="custom-file-label" for="input-{{ $name }}">{{ $label }}</label>

        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>
</div>
