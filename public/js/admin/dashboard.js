/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/dashboard.js":
/*!*****************************************!*\
  !*** ./resources/js/admin/dashboard.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../argon/components/chart-defaults */ "./resources/js/argon/components/chart-defaults.js");
//
// Orders chart
//


var OrdersChart = function () {
  //
  // Methods
  //
  // Init chart
  function initChart($chart, type, dataset, mode) {
    dataset.datasets = dataset.datasets.map(function (set) {
      if (set.backgroundColor && set.backgroundColor !== undefined) {
        set.backgroundColor = set.backgroundColor.split('.').reduce(function (o, i) {
          return o[i];
        }, _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__["Charts"].colors);
      }

      return set;
    }); // Create chart

    var ordersChart = new Chart($chart, {
      type: type,
      options: {
        scales: {
          yAxes: [{
            gridLines: {
              color: 'gridlines' !== mode ? _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__["Charts"].colors.transparent : _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__["Charts"].colors.gray[500],
              zeroLineColor: 'gridlines' !== mode ? _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__["Charts"].colors.transparent : _argon_components_chart_defaults__WEBPACK_IMPORTED_MODULE_0__["Charts"].colors.gray[500]
            },
            ticks: {
              callback: function callback(value) {
                if (!(value % 10)) {
                  //return '$' + value + 'k'
                  return value;
                }
              }
            }
          }]
        },
        tooltips: {
          callbacks: {
            label: function label(item, data) {
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
    }); // Save to jQuery object

    $chart.data('chart', ordersChart);
  } //
  // Variables
  //


  if (chartsToRender !== undefined) {
    chartsToRender.forEach(function (renderChart) {
      var $chart = $(renderChart.canvasSelector);

      if ($chart.length) {
        initChart($chart, renderChart.type, renderChart.dataset, renderChart.mode);
      }
    });
  }
}();

/***/ }),

/***/ "./resources/js/argon/components/chart-defaults.js":
/*!*********************************************************!*\
  !*** ./resources/js/argon/components/chart-defaults.js ***!
  \*********************************************************/
/*! exports provided: Charts */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Charts", function() { return Charts; });
//
// Charts
//


function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function _typeof(obj) {
      return typeof obj;
    };
  } else {
    _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

var Charts = function () {
  // Variable
  var $toggle = $('[data-toggle="chart"]');
  var mode = 'light'; //(themeMode) ? themeMode : 'light';

  var fonts = {
    base: 'Open Sans'
  }; // Colors

  var colors = {
    gray: {
      100: '#f6f9fc',
      200: '#e9ecef',
      300: '#dee2e6',
      400: '#ced4da',
      500: '#adb5bd',
      600: '#8898aa',
      700: '#525f7f',
      800: '#32325d',
      900: '#212529'
    },
    theme: {
      'default': '#172b4d',
      'primary': '#5e72e4',
      'secondary': '#f4f5f7',
      'info': '#11cdef',
      'success': '#2dce89',
      'danger': '#f5365c',
      'warning': '#fb6340'
    },
    black: '#12263F',
    white: '#FFFFFF',
    transparent: 'transparent'
  }; // Methods
  // Chart.js global options

  function chartOptions() {
    // Options
    var options = {
      defaults: {
        global: {
          responsive: true,
          maintainAspectRatio: false,
          defaultColor: mode == 'dark' ? colors.gray[700] : colors.gray[600],
          defaultFontColor: mode == 'dark' ? colors.gray[700] : colors.gray[600],
          defaultFontFamily: fonts.base,
          defaultFontSize: 13,
          layout: {
            padding: 0
          },
          legend: {
            display: false,
            position: 'bottom',
            labels: {
              usePointStyle: true,
              padding: 16
            }
          },
          elements: {
            point: {
              radius: 0,
              backgroundColor: colors.theme['primary']
            },
            line: {
              tension: .4,
              borderWidth: 4,
              borderColor: colors.theme['primary'],
              backgroundColor: colors.transparent,
              borderCapStyle: 'rounded'
            },
            rectangle: {
              backgroundColor: colors.theme['warning']
            },
            arc: {
              backgroundColor: colors.theme['primary'],
              borderColor: mode == 'dark' ? colors.gray[800] : colors.white,
              borderWidth: 4
            }
          },
          tooltips: {
            enabled: false,
            mode: 'index',
            intersect: false,
            custom: function custom(model) {
              // Get tooltip
              var $tooltip = $('#chart-tooltip'); // Create tooltip on first render

              if (!$tooltip.length) {
                $tooltip = $('<div id="chart-tooltip" class="popover bs-popover-top" role="tooltip"></div>'); // Append to body

                $('body').append($tooltip);
              } // Hide if no tooltip


              if (model.opacity === 0) {
                $tooltip.css('display', 'none');
                return;
              }

              function getBody(bodyItem) {
                return bodyItem.lines;
              } // Fill with content


              if (model.body) {
                var titleLines = model.title || [];
                var bodyLines = model.body.map(getBody);
                var html = ''; // Add arrow

                html += '<div class="arrow"></div>'; // Add header

                titleLines.forEach(function (title) {
                  html += '<h3 class="popover-header text-center">' + title + '</h3>';
                }); // Add body

                bodyLines.forEach(function (body, i) {
                  var colors = model.labelColors[i];
                  var styles = 'background-color: ' + colors.backgroundColor;
                  var indicator = '<span class="badge badge-dot"><i class="bg-primary"></i></span>';
                  var align = bodyLines.length > 1 ? 'justify-content-left' : 'justify-content-center';
                  html += '<div class="popover-body d-flex align-items-center ' + align + '">' + indicator + body + '</div>';
                });
                $tooltip.html(html);
              } // Get tooltip position


              var $canvas = $(this._chart.canvas);
              var canvasWidth = $canvas.outerWidth();
              var canvasHeight = $canvas.outerHeight();
              var canvasTop = $canvas.offset().top;
              var canvasLeft = $canvas.offset().left;
              var tooltipWidth = $tooltip.outerWidth();
              var tooltipHeight = $tooltip.outerHeight();
              var top = canvasTop + model.caretY - tooltipHeight - 16;
              var left = canvasLeft + model.caretX - tooltipWidth / 2; // Display tooltip

              $tooltip.css({
                'top': top + 'px',
                'left': left + 'px',
                'display': 'block',
                'z-index': '100'
              });
            },
            callbacks: {
              label: function label(item, data) {
                var label = data.datasets[item.datasetIndex].label || '';
                var yLabel = item.yLabel;
                var content = '';

                if (data.datasets.length > 1) {
                  content += '<span class="badge badge-primary mr-auto">' + label + '</span>';
                }

                content += '<span class="popover-body-value">' + yLabel + '</span>';
                return content;
              }
            }
          }
        },
        doughnut: {
          cutoutPercentage: 83,
          tooltips: {
            callbacks: {
              title: function title(item, data) {
                var title = data.labels[item[0].index];
                return title;
              },
              label: function label(item, data) {
                var value = data.datasets[0].data[item.index];
                var content = '';
                content += '<span class="popover-body-value">' + value + '</span>';
                return content;
              }
            }
          },
          legendCallback: function legendCallback(chart) {
            var data = chart.data;
            var content = '';
            data.labels.forEach(function (label, index) {
              var bgColor = data.datasets[0].backgroundColor[index];
              content += '<span class="chart-legend-item">';
              content += '<i class="chart-legend-indicator" style="background-color: ' + bgColor + '"></i>';
              content += label;
              content += '</span>';
            });
            return content;
          }
        }
      }
    }; // yAxes

    Chart.scaleService.updateScaleDefaults('linear', {
      gridLines: {
        borderDash: [2],
        borderDashOffset: [2],
        color: mode == 'dark' ? colors.gray[900] : colors.gray[300],
        drawBorder: false,
        drawTicks: false,
        lineWidth: 0,
        zeroLineWidth: 0,
        zeroLineColor: mode == 'dark' ? colors.gray[900] : colors.gray[300],
        zeroLineBorderDash: [2],
        zeroLineBorderDashOffset: [2]
      },
      ticks: {
        beginAtZero: true,
        padding: 10,
        callback: function callback(value) {
          if (!(value % 10)) {
            return value;
          }
        }
      }
    }); // xAxes

    Chart.scaleService.updateScaleDefaults('category', {
      gridLines: {
        drawBorder: false,
        drawOnChartArea: false,
        drawTicks: false
      },
      ticks: {
        padding: 20
      },
      maxBarThickness: 10
    });
    return options;
  } // Parse global options


  function parseOptions(parent, options) {
    for (var item in options) {
      if (_typeof(options[item]) !== 'object') {
        parent[item] = options[item];
      } else {
        parseOptions(parent[item], options[item]);
      }
    }
  } // Push options


  function pushOptions(parent, options) {
    for (var item in options) {
      if (Array.isArray(options[item])) {
        options[item].forEach(function (data) {
          parent[item].push(data);
        });
      } else {
        pushOptions(parent[item], options[item]);
      }
    }
  } // Pop options


  function popOptions(parent, options) {
    for (var item in options) {
      if (Array.isArray(options[item])) {
        options[item].forEach(function (data) {
          parent[item].pop();
        });
      } else {
        popOptions(parent[item], options[item]);
      }
    }
  } // Toggle options


  function toggleOptions(elem) {
    var options = elem.data('add');
    var $target = $(elem.data('target'));
    var $chart = $target.data('chart');

    if (elem.is(':checked')) {
      // Add options
      pushOptions($chart, options); // Update chart

      $chart.update();
    } else {
      // Remove options
      popOptions($chart, options); // Update chart

      $chart.update();
    }
  } // Update options


  function updateOptions(elem) {
    var options = elem.data('update');
    var $target = $(elem.data('target'));
    var $chart = $target.data('chart'); // Parse options

    parseOptions($chart, options); // Toggle ticks

    toggleTicks(elem, $chart); // Update chart

    $chart.update();
  } // Toggle ticks


  function toggleTicks(elem, $chart) {
    if (elem.data('prefix') !== undefined || elem.data('prefix') !== undefined) {
      var prefix = elem.data('prefix') ? elem.data('prefix') : '';
      var suffix = elem.data('suffix') ? elem.data('suffix') : ''; // Update ticks

      $chart.options.scales.yAxes[0].ticks.callback = function (value) {
        if (!(value % 10)) {
          return prefix + value + suffix;
        }
      }; // Update tooltips


      $chart.options.tooltips.callbacks.label = function (item, data) {
        var label = data.datasets[item.datasetIndex].label || '';
        var yLabel = item.yLabel;
        var content = '';

        if (data.datasets.length > 1) {
          content += '<span class="popover-body-label mr-auto">' + label + '</span>';
        }

        content += '<span class="popover-body-value">' + prefix + yLabel + suffix + '</span>';
        return content;
      };
    }
  } // Events
  // Parse global options


  if (window.Chart) {
    parseOptions(Chart, chartOptions());
  } // Toggle options


  $toggle.on({
    'change': function change() {
      var $this = $(this);

      if ($this.is('[data-add]')) {
        toggleOptions($this);
      }
    },
    'click': function click() {
      var $this = $(this);

      if ($this.is('[data-update]')) {
        updateOptions($this);
      }
    }
  }); // Return

  return {
    colors: colors,
    fonts: fonts,
    mode: mode
  };
}();

/***/ }),

/***/ "./resources/sass/admin.scss":
/*!***********************************!*\
  !*** ./resources/sass/admin.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*****************************************************************************************************!*\
  !*** multi ./resources/js/admin/dashboard.js ./resources/sass/app.scss ./resources/sass/admin.scss ***!
  \*****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/raksha.devi/Documents/projects/bizmod/01 - code/bizmod/resources/js/admin/dashboard.js */"./resources/js/admin/dashboard.js");
__webpack_require__(/*! /home/raksha.devi/Documents/projects/bizmod/01 - code/bizmod/resources/sass/app.scss */"./resources/sass/app.scss");
module.exports = __webpack_require__(/*! /home/raksha.devi/Documents/projects/bizmod/01 - code/bizmod/resources/sass/admin.scss */"./resources/sass/admin.scss");


/***/ })

/******/ });
//# sourceMappingURL=dashboard.js.map