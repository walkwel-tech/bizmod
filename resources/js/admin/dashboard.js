//
// Orders chart
//

import {
    Charts
} from '../argon/components/chart-defaults';

var OrdersChart = (function () {

    //
    // Variables
    //

    var $chart = $('#chart-orders');
    var $ordersSelect = $('[name="ordersSelect"]');


    //
    // Methods
    //

    // Init chart
    function initChart($chart) {

        // Create chart
        var ordersChart = new Chart($chart, {
            type: 'bar',
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            callback: function (value) {
                                if (!(value % 10)) {
                                    //return '$' + value + 'k'
                                    return value
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            var label = data.datasets[item.datasetIndex].label || '';
                            var yLabel = item.yLabel;
                            var content = '';

                            if (data.datasets.length > 1) {
                                content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            }

                            content += '<span class="popover-body-value">' + yLabel + '</span>';

                            return content;
                        }
                    }
                }
            },
            data: {
                labels: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales',
                    data: [25, 20, 30, 22, 17, 29]
                }]
            }
        });

        // Save to jQuery object
        $chart.data('chart', ordersChart);
    }


    // Init chart
    if ($chart.length) {
        initChart($chart);
    }

})();


//
// Charts
//

'use strict';

//
// Sales chart
//

var SalesChart = (function () {

    // Variables

    var $chart = $('#chart-sales');


    // Methods

    function init($chart) {

        var salesChart = new Chart($chart, {
            type: 'line',
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: Charts.colors.gray[900],
                            zeroLineColor: Charts.colors.gray[900]
                        },
                        ticks: {
                            callback: function (value) {
                                if (!(value % 10)) {
                                    return '$' + value + 'k';
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            var label = data.datasets[item.datasetIndex].label || '';
                            var yLabel = item.yLabel;
                            var content = '';

                            if (data.datasets.length > 1) {
                                content += '<span class="popover-body-label mr-auto">' + label + '</span>';
                            }

                            content += '<span class="popover-body-value">$' + yLabel + 'k</span>';
                            return content;
                        }
                    }
                }
            },
            data: {
                labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Performance',
                    data: [0, 20, 10, 30, 15, 40, 20, 60, 60]
                }]
            }
        });

        // Save to jQuery object

        $chart.data('chart', salesChart);

    };


    // Events

    if ($chart.length) {
        init($chart);
    }

})();
