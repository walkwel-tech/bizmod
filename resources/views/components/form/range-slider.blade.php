<!-- Range slider container -->
<div class="input-range-slider-container">
    <div class="input-range-slider" id="slider-{{ $name }}" data-range-value-min="{{ $min }}"
        data-range-value-max="{{ $max }}"></div>
    <!-- Range slider values -->
    <div class="row">
        <div class="col-6">
            <span class="range-slider-value value-low" data-range-value-low="{{ $valueMin }}" id="slider-{{ $name }}-value-low"></span>
            <input name="{{ $name }}['min']" type="hidden" class="range-slider-value value-low" value="{{ $valueMin }}" id="slider-input-{{ $name }}-value-low"/>
        </div>
        <div class="col-6 text-right">
            <span class="range-slider-value value-high" data-range-value-high="{{ $valueMax }}" id="slider-{{ $name }}-value-high"></span>
            <input name="{{ $name }}['max']" type="hidden" class="range-slider-value value-high" value="{{ $valueMax }}" id="slider-input-{{ $name }}-value-high">
        </div>
    </div>
</div>
