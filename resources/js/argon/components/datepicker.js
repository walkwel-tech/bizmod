
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

		const options = {
            dateFormat: format,
            allowInput: true,
            plugins: [],
            onChange: (selectedDates, dateStr, instance) => {
                console.log($this.data('selected-dates'), 'lk');

                const dateStart = formatDate(selectedDates['0']);
                const dateEnd = formatDate(selectedDates['1']);
                const selected_dates = dateStart + ',' + dateEnd;
                $($this.data('selected-dates')).val(selected_dates);
            }
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

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
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
