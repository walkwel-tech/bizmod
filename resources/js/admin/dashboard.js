//
// Orders chart
//

import {
    Charts
} from '../argon/components/chart-defaults';


var OrdersChart = (function () {
    //
    // Methods
    //

    // Init chart
    function initChart($chart, type, dataset) {

        dataset.datasets = dataset.datasets.map(set => {
            if (set.backgroundColor && set.backgroundColor !== undefined) {
                set.backgroundColor = set.backgroundColor.split('.').reduce((o,i)=>o[i], Charts.colors);
            }
            return set;
        })

        // Create chart
        var ordersChart = new Chart($chart, {
            type: type,
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
            data: dataset
        });

        // Save to jQuery object
        $chart.data('chart', ordersChart);
    }

    //
    // Variables
    //

    if (chartsToRender !== undefined) {
        chartsToRender.forEach(renderChart => {
            const $chart = $(renderChart.canvasSelector);
            if ($chart.length) {
                initChart($chart, renderChart.type, renderChart.dataset);
            }
        });
    }

    // var $chart = $('#chart-orders');
    // var $ordersSelect = $('[name="ordersSelect"]');


    // Init chart
    // if ($chart.length) {
        // initChart($chart);
    // }

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




    // Methods

    function init($chart, type, dataset) {

        var salesChart = new Chart($chart, {
            type: type,
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
                                    return value ;
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
            data: dataset
        });

        // Save to jQuery object

        $chart.data('chart', salesChart);

    };
    if( salesChartToRender !== undefined )
    {
        salesChartToRender.forEach(renderChart =>{
            const $chart = $(renderChart.canvasSelector);
            init($chart, renderChart.type , renderChart.dataset);
        });
    }


    // var $chart = $('#chart-sales');
    // Events

    // if ($chart.length) {
    //     init($chart);
    // }

})();
