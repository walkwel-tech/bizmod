<!-- Simple slider -->
<div class="input-slider-container">
    <div id="slider-{{ $name }}" class="input-slider" data-range-value-min="{{ $min }}" data-range-value-max="{{ $max }}"></div>
    <!-- Input slider values -->
    <div class="row mt-3">
        <div class="col-6">
            <span id="slider-{{ $name }}-value" class="range-slider-value" data-range-value-low="{{ $min }}"></span>
            <input name="{{ $name }}" type="hidden" class="range-slider-value value-low" value="{{ $value }}" id="slider-input-{{ $name }}-value-low"/>
        </div>
    </div>
</div>
