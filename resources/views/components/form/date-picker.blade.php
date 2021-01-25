<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    @if (!$hideLabel)
    <label class="form-control-label" for="input_date-picker-{{ $name }}">
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
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
        </div>
        <input {{ $attributes }} type="{{ $fieldType }}" name="{{ $name }}" id="input_date-picker-{{ $name }}" class="form-control{{ $singlePicker ? ' datepicker' : '' }}{{ $errors->has($name) ? ' is-invalid' : '' }}" placeholder="{{ __($placeholder) }}" value="{{ old($name, $value) }}" data-format="{{ $format }}" data-type="{{ $type }}">
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>
</div>
