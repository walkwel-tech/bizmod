<div class="row col-12">
    <div class="col">
            <div class="form-group{{ $errors->has($name . "[start]") ? ' has-error' : '' }}">
                @if (!$hideLabel)
                <label class="form-control-label" for="input_date-picker-{{ $name }}-start">
                    {{ $title }} Start
                </label>
                @endif
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input {{ $attributes }} type="{{ $fieldType }}" name="{{ $name . "[start]" }}" id="input_date-picker-{{ $name }}-start" class="form-control date-range-start{{ $errors->has("{$name}.start") ? ' is-invalid' : '' }}" placeholder="{{ __($placeholder) }}" value="{{ old("{$name}.start", $valueStart) }}" data-format="{{ $format }}" data-type="{{ $type }}" data-to="#input_date-picker-{{ $name }}-end">
                    @if ($errors->has("{$name}.start"))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first("{$name}.start") }}
                        </span>
                    @endif
                </div>
            </div>
    </div>

    <div class="col">
        <div class="form-group{{ $errors->has($name . "[start]") ? ' has-error' : '' }}">
            @if (!$hideLabel)
            <label class="form-control-label" for="input_date-picker-{{ $name }}-end">
                {{ $title }} End
            </label>
            @endif
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                </div>
                <input {{ $attributes }} type="{{ $fieldType }}" name="{{ $name . "[end]" }}" id="input_date-picker-{{ $name }}-end" class="form-control date-range-end{{ $errors->has("{$name}.end") ? ' is-invalid' : '' }}" placeholder="{{ __($placeholder) }}" value="{{ old("{$name}.end", $valueEnd) }}" data-format="{{ $format }}" data-type="{{ $type }}">
                @if ($errors->has("{$name}.end")))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first("{$name}.end") }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if($slot)
    {{ $slot }}
    @endif
</div>
