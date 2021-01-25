
//
// Bootstrap Datepicker
//

'use strict';
// require('bootstrap-datepicker/dist/js/bootstrap-datepicker');
import "flatpickr";

import rangePlugin from 'flatpickr/dist/plugins/rangePlugin';

var Datepicker = (function() {

	// Variables
    const $datepicker = $('.datepicker');

	// Methods
	function init($this) {
        let format = $this.data('format');
        if (!format) {
            format = 'Y-m-d';
        }
		var options = {
            dateFormat: format,
            allowInput: true
        };

        switch ($this.data('type')) {
            case 'with-time':
                options.enableTime = true;
                break;

            case 'only-time':
                options.enableTime = true;
                options.noCalendar = true;
                break;

            default:
                break;
        }

		$this.flatpickr(options);
	}

    function initRange($this) {
        let format = $this.data('format');
        if (!format) {
            format = 'Y-m-d';
        }

		var options = {
            dateFormat: format,
            allowInput: true,
            plugins: []
        };

        switch ($this.data('type')) {
            case 'with-time':
                options.enableTime = true;
                break;

            default:
                break;
        }

        if ($this.data('to')) {
            options.plugins.push(
                new rangePlugin({ input: $this.data('to')})
            );
        }

		$this.flatpickr(options);
	}

	// Events

	if ($datepicker.length) {
		$datepicker.each(function() {
			init($(this));
		});
    }

    const $dateRange = $(".date-range-start");
    if ($dateRange.length) {
        $dateRange.each (function () {
            initRange($(this));
        })
    }

})();
