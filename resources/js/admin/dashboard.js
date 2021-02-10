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
    function initChart($chart, type, dataset, mode) {

        dataset.datasets = dataset.datasets.map(set => {
            if (set.borderColor && set.borderColor !== undefined) {
                set.borderColor = set.borderColor.split('.').reduce((o,i)=>o[i], Charts.colors);
            }

            if (set.backgroundColor && set.backgroundColor !== undefined) {
                set.backgroundColor = set.backgroundColor.split('.').reduce((o,i)=>o[i], Charts.colors);
            }
            return set;
        })
        // console.log(dataset);
        // Create chart
        var ordersChart = new Chart($chart, {
            type: type,
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            color:  ('gridlines' !== mode) ? Charts.colors.transparent : Charts.colors.gray[500],
                            zeroLineColor:  ('gridlines' !== mode) ? Charts.colors.transparent : Charts.colors.gray[500]
                        },
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

                initChart($chart, renderChart.type, renderChart.dataset, renderChart.mode);
            }
        });
    }
})();
