//
// Form control
//

'use strict';

import noUiSlider from 'nouislider';

var noUiSliderRunner = (function () {

    // Variables

    // var $sliderContainer = $('.input-slider-container'),
    // 		$slider = $('.input-slider'),
    // 		$sliderId = $slider.attr('id'),
    // 		$sliderMinValue = $slider.data('range-value-min');
    // 		$sliderMaxValue = $slider.data('range-value-max');;


    // // Methods
    //
    // function init($this) {
    // 	$this.on('focus blur', function(e) {
    //       $this.parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    //   }).trigger('blur');
    // }
    //
    //
    // // Events
    //
    // if ($input.length) {
    // 	init($input);
    // }



    if ($(".input-slider-container")[0]) {

        $('.input-slider-container').each(function () {

            var slider = $(this).find('.input-slider');
            var sliderId = slider.attr('id');
            var minValue = slider.data('range-value-min');
            var maxValue = slider.data('range-value-max');

            var sliderValue = $(this).find('span.range-slider-value');
            var sliderValueId = sliderValue.attr('id');
            var startValue = sliderValue.data('range-value-low');
            var sliderInputElementId = $(this).find('input.range-slider-value').attr('id');

            var sliderElement = document.getElementById(sliderId),
                sliderValueElement = document.getElementById(sliderValueId),
                sliderInputElement = document.getElementById(sliderInputElementId);

            noUiSlider.create(sliderElement, {
                start: [parseInt(startValue)],
                connect: [true, false],
                //step: 1000,
                range: {
                    'min': [parseInt(minValue)],
                    'max': [parseInt(maxValue)]
                }
            });

            sliderElement.noUiSlider.on('update', function (a, b) {
                sliderValueElement.textContent = a[b];
                sliderInputElement.value = a[b];
            });
        })
    }

    if ($(".input-range-slider-container")[0]) {

        $('.input-range-slider-container').each(function () {
            const slider = $(this).find('.input-range-slider');
            const sliderId = slider.attr('id');

            const sliderMin = $(this).find('span.range-slider-value.value-low');
            const sliderMinId = sliderMin.attr('id');
            const inputMinId = $(this).find('input.range-slider-value.value-low').attr('id');

            const sliderMax = $(this).find('span.range-slider-value.value-high');
            const sliderMaxId = sliderMax.attr('id');
            const inputMaxId = $(this).find('input.range-slider-value.value-high').attr('id');

            const elementSlider = document.getElementById(sliderId),
                elementMin = document.getElementById(sliderMinId),
                elementMax = document.getElementById(sliderMaxId),
                labels = [elementMin, elementMax],
                inputs = [document.getElementById(inputMinId), document.getElementById(inputMaxId)];

            noUiSlider.create(elementSlider, {
                start: [parseInt(elementMin.getAttribute('data-range-value-low')), parseInt(elementMax.getAttribute('data-range-value-high'))],
                connect: !0,
                range: {
                    min: parseInt(elementSlider.getAttribute('data-range-value-min')),
                    max: parseInt(elementSlider.getAttribute('data-range-value-max'))
                }
            });

            elementSlider.noUiSlider.on("update", function (a, b) {
                labels[b].textContent = a[b];
                inputs[b].value = a[b];
            });
        });
    }

})();
