<div class="row col-12">
    <div class="col">
            <div class="form-group{{ $errors->has($nameStart) ? ' has-error' : '' }}">
                @if (!$hideLabel)
                <label class="form-control-label" for="input_date-picker-{{ $pickerId }}-start">
                    {{ $title }} Start
                </label>
                @endif
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input {{ $attributes }} type="{{ $fieldType }}" name="{{ $nameStart }}" id="input_date-picker-{{ $pickerId }}-start" class="form-control date-range-start{{ $errors->has("{$name}.start") ? ' is-invalid' : '' }}" placeholder="{{ __($startdateplaceholder) }}" value="{{ old("{$name}.start", $valueStart) }}" data-format="{{ $format }}" data-type="{{ $type }}" data-to="#input_date-picker-{{ $pickerId }}-end" data-selected-dates="#selected-dates--{{ $pickerId }}">
                    @if ($errors->has("{$name}.start"))
                        <span class="invalid-feedback" role="alert">
                            {{ $errors->first("{$name}.start") }}
                        </span>
                    @endif
                </div>
            </div>
    </div>

    <div class="col">
        <div class="form-group{{ $errors->has($nameStart) ? ' has-error' : '' }}">
            @if (!$hideLabel)
            <label class="form-control-label" for="input_date-picker-{{ $pickerId }}-end">
                {{ $title }} End
            </label>
            @endif
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                </div>
                <input {{ $attributes }} type="{{ $fieldType }}" name="{{ $nameEnd }}" id="input_date-picker-{{ $pickerId }}-end" class="form-control date-range-end{{ $errors->has("{$name}.end") ? ' is-invalid' : '' }}" placeholder="{{ __($enddateplaceholder) }}" value="{{ old("{$name}.end", $valueEnd) }}" data-format="{{ $format }}" data-type="{{ $type }}">
                @if ($errors->has("{$name}.end")))
                    <span class="invalid-feedback" role="alert">
                        {{ $errors->first("{$name}.end") }}
                    </span>
                @endif

            </div>
            <input type="hidden" name="{{ $name }}" id="selected-dates--{{ $pickerId }}" />
        </div>
    </div>

    @if($slot)
    {{ $slot }}
    @endif
</div>
