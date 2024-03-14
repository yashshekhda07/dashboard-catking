<script>
    $(document).ready(function() {
        var EchartsTotalRevenue = function() {
            var _columnsBasicLightExample = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var columns_basic_element = document.getElementById('total_revenue');

                if (columns_basic_element) {

                    // Initialize chart
                    var columns_basic = echarts.init(columns_basic_element, null, {
                        renderer: 'svg'
                    });

                    columns_basic.setOption({

                        // Define colors
                        color: ['#0280FC2E', '#328FEA'],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            lineHeight: 22,
                            textBorderColor: 'transparent'
                        },

                        // Chart animation duration
                        animationDuration: 750,

                        // Setup grid
                        grid: {
                            left: 5,
                            right: 45,
                            top: 35,
                            bottom: 0,
                            containLabel: true
                        },

                        // Add legend
                        // legend: {
                        //     data: ['Evaporation', 'Precipitation'],
                        //     itemHeight: 8,
                        //     itemGap: 30,
                        //     textStyle: {
                        //         color: 'var(--body-color)',
                        //         padding: [0, 5]
                        //     }
                        // },

                        // Add tooltip
                        tooltip: {
                            trigger: 'axis',
                            className: 'shadow-sm rounded',
                            backgroundColor: 'var(--white)',
                            borderColor: 'var(--gray-400)',
                            padding: 15,
                            textStyle: {
                                color: '#000'
                            },
                            axisPointer: {
                                type: 'shadow',
                                shadowStyle: {
                                    color: 'rgba(var(--body-color-rgb), 0.025)'
                                }
                            },
                            formatter: function(params) {
                                var tooltip = '<div class="text-center"><b>' + params[0]
                                    .name + '</b><br>';
                                tooltip += '<span>' + params[1].value + '<span><br>';
                                // tooltip += '<span>' + params[0].value + '<span><br>';
                                var oldValue = params[0].value > 0 ? params[0].value : 1;
                                var per = (params[1].value - oldValue) / oldValue *
                                    100;
                                var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                    params[1].value != 0 ? 100 : 0);
                                tooltip += percantage > 0 ?
                                    '<span class="text-success ms-2">' + percantage +
                                    '% <i class="ph-trend-up me-2"></i></span>' : (
                                        percantage < 0 ? '<span class="text-danger ms-2">' +
                                        percantage +
                                        '% <i class="ph-trend-down me-2"></i></span>' :
                                        '<span class="text-info ms-2">' +
                                        percantage +
                                        '% </span>');
                                tooltip += '</div>';
                                return tooltip;
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: [
                                'CAT Intensive Mock',
                                'CAT Turbo Mock',
                                'CAT Advance Mock',
                                'CATKing All Mocks',
                                'NMAT Mocks',
                                'SNAP Mocks',
                                'CET Mocks',
                                'SRCC GBO Mocks',
                                'IIFT Mocks',
                                'Books & Mocks Course',
                                'TISSNET Mocks',
                                'MAT Mocks',
                                'ATMA Mock',
                            ],
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: 'var(--gray-500)'
                                }
                            },
                            splitLine: {
                                show: true,
                                lineStyle: {
                                    color: 'var(--gray-300)',
                                    type: 'dashed'
                                }
                            }
                        }],

                        // Vertical axis
                        yAxis: [{
                            type: 'value',
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            },
                            axisLine: {
                                show: true,
                                lineStyle: {
                                    color: 'var(--gray-500)'
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: 'var(--gray-300)'
                                }
                            },
                            splitArea: {
                                show: true,
                                areaStyle: {
                                    color: ['rgba(var(--white-rgb), .01)',
                                        'rgba(var(--black-rgb), .01)'
                                    ]
                                }
                            }
                        }],

                        // Add series
                        series: [{
                                name: 'Last Day',
                                type: 'bar',
                                data: [
                                    "{{ $mocks['last_day_revenue']['cat-mock'] }}",
                                    "{{ $mocks['last_day_revenue']['cat-turbo-mock'] }}",
                                    "{{ $mocks['last_day_revenue']['cat-advance-mock'] }}",
                                    "{{ $mocks['last_day_revenue']['all-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['nmat-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['snap-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['cet-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['srcc-gbo-mock'] }}",
                                    "{{ $mocks['last_day_revenue']['iift-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['books-and-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['tissnet-mocks'] }}",
                                    "{{ $mocks['last_day_revenue']['mat-mock'] }}",
                                    "{{ $mocks['last_day_revenue']['atma-mock'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)'
                                        }
                                    }
                                },
                                // markLine: {
                                //     data: [{
                                //         type: 'average',
                                //         name: 'Average'
                                //     }],
                                //     label: {
                                //         color: 'var(--body-color)'
                                //     }
                                // }
                            },
                            {
                                name: 'Today',
                                type: 'bar',
                                data: [
                                    "{{ $mocks['today_revenue']['cat-mock'] }}",
                                    "{{ $mocks['today_revenue']['cat-turbo-mock'] }}",
                                    "{{ $mocks['today_revenue']['cat-advance-mock'] }}",
                                    "{{ $mocks['today_revenue']['all-mocks'] }}",
                                    "{{ $mocks['today_revenue']['nmat-mocks'] }}",
                                    "{{ $mocks['today_revenue']['snap-mocks'] }}",
                                    "{{ $mocks['today_revenue']['cet-mocks'] }}",
                                    "{{ $mocks['today_revenue']['srcc-gbo-mock'] }}",
                                    "{{ $mocks['today_revenue']['iift-mocks'] }}",
                                    "{{ $mocks['today_revenue']['books-and-mocks'] }}",
                                    "{{ $mocks['today_revenue']['tissnet-mocks'] }}",
                                    "{{ $mocks['today_revenue']['mat-mock'] }}",
                                    "{{ $mocks['today_revenue']['atma-mock'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)'
                                        }
                                    }
                                },
                                // markLine: {
                                //     data: [{
                                //         type: 'average',
                                //         name: 'Average'
                                //     }],
                                //     label: {
                                //         color: 'var(--body-color)'
                                //     }
                                // }
                            }
                        ]
                    });
                }


                //
                // Resize charts
                //

                // Resize function
                var triggerChartResize = function() {
                    columns_basic_element && columns_basic.resize();
                };

                // On sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', triggerChartResize);
                    });
                }

                // On window resize
                var resizeCharts;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeCharts);
                    resizeCharts = setTimeout(function() {
                        triggerChartResize();
                    }, 200);
                });
            };

            return {
                init: function() {
                    _columnsBasicLightExample();
                }
            }
        }();

        var EchartsNoOfEnrollment = function() {
            var _columnsBasicLightExample = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var columns_basic_element = document.getElementById('no_of_enrollment');

                if (columns_basic_element) {

                    // Initialize chart
                    var columns_basic = echarts.init(columns_basic_element, null, {
                        renderer: 'svg'
                    });

                    columns_basic.setOption({

                        // Define colors
                        color: ['#6186FF4D', '#6186FF'],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            lineHeight: 22,
                            textBorderColor: 'transparent'
                        },

                        // Chart animation duration
                        animationDuration: 750,

                        // Setup grid
                        grid: {
                            left: 5,
                            right: 45,
                            top: 35,
                            bottom: 0,
                            containLabel: true
                        },

                        // Add legend
                        // legend: {
                        //     data: ['Evaporation', 'Precipitation'],
                        //     itemHeight: 8,
                        //     itemGap: 30,
                        //     textStyle: {
                        //         color: 'var(--body-color)',
                        //         padding: [0, 5]
                        //     }
                        // },

                        // Add tooltip
                        tooltip: {
                            trigger: 'axis',
                            className: 'shadow-sm rounded',
                            backgroundColor: 'var(--white)',
                            borderColor: 'var(--gray-400)',
                            padding: 15,
                            textStyle: {
                                color: '#000'
                            },
                            axisPointer: {
                                type: 'shadow',
                                shadowStyle: {
                                    color: 'rgba(var(--body-color-rgb), 0.025)'
                                }
                            },
                            formatter: function(params) {
                                var tooltip = '<div class="text-center"><b>' + params[0]
                                    .name + '</b><br>';
                                tooltip += '<span>' + params[1].value + '<span><br>';
                                // tooltip += '<span>' + params[0].value + '<span><br>';
                                var oldValue = params[0].value > 0 ? params[0].value : 1;
                                var per = (params[1].value - oldValue) / oldValue *
                                    100;
                                var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                    params[1].value != 0 ? 100 : 0);
                                tooltip += percantage > 0 ?
                                    '<span class="text-success ms-2">' + percantage +
                                    '% <i class="ph-trend-up me-2"></i></span>' : (
                                        percantage < 0 ? '<span class="text-danger ms-2">' +
                                        percantage +
                                        '% <i class="ph-trend-down me-2"></i></span>' :
                                        '<span class="text-info ms-2">' +
                                        percantage +
                                        '% </span>');
                                tooltip += '</div>';
                                return tooltip;
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: [
                                'CAT Intensive Mock',
                                'CAT Turbo Mock',
                                'CAT Advance Mock',
                                'CATKing All Mocks',
                                'NMAT Mocks',
                                'SNAP Mocks',
                                'CET Mocks',
                                'SRCC GBO Mocks',
                                'IIFT Mocks',
                                'Books & Mocks Course',
                                'TISSNET Mocks',
                                'MAT Mocks',
                                'ATMA Mock',
                            ],
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            },
                            axisLine: {
                                lineStyle: {
                                    color: 'var(--gray-500)'
                                }
                            },
                            splitLine: {
                                show: true,
                                lineStyle: {
                                    color: 'var(--gray-300)',
                                    type: 'dashed'
                                }
                            }
                        }],

                        // Vertical axis
                        yAxis: [{
                            type: 'value',
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)'
                            },
                            axisLine: {
                                show: true,
                                lineStyle: {
                                    color: 'var(--gray-500)'
                                }
                            },
                            splitLine: {
                                lineStyle: {
                                    color: 'var(--gray-300)'
                                }
                            },
                            splitArea: {
                                show: true,
                                areaStyle: {
                                    color: ['rgba(var(--white-rgb), .01)',
                                        'rgba(var(--black-rgb), .01)'
                                    ]
                                }
                            }
                        }],

                        // Add series
                        series: [{
                                name: 'Last Day',
                                type: 'bar',
                                data: [
                                    "{{ $mocks['last_day_enrollment']['cat-mock'] }}",
                                    "{{ $mocks['last_day_enrollment']['cat-turbo-mock'] }}",
                                    "{{ $mocks['last_day_enrollment']['cat-advance-mock'] }}",
                                    "{{ $mocks['last_day_enrollment']['all-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['nmat-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['snap-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['cet-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['srcc-gbo-mock'] }}",
                                    "{{ $mocks['last_day_enrollment']['iift-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['books-and-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['tissnet-mocks'] }}",
                                    "{{ $mocks['last_day_enrollment']['mat-mock'] }}",
                                    "{{ $mocks['last_day_enrollment']['atma-mock'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)'
                                        }
                                    }
                                },
                                // markLine: {
                                //     data: [{
                                //         type: 'average',
                                //         name: 'Average'
                                //     }],
                                //     label: {
                                //         color: 'var(--body-color)'
                                //     }
                                // }
                            },
                            {
                                name: 'Today',
                                type: 'bar',
                                data: [
                                    "{{ $mocks['today_enrollment']['cat-mock'] }}",
                                    "{{ $mocks['today_enrollment']['cat-turbo-mock'] }}",
                                    "{{ $mocks['today_enrollment']['cat-advance-mock'] }}",
                                    "{{ $mocks['today_enrollment']['all-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['nmat-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['snap-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['cet-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['srcc-gbo-mock'] }}",
                                    "{{ $mocks['today_enrollment']['iift-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['books-and-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['tissnet-mocks'] }}",
                                    "{{ $mocks['today_enrollment']['mat-mock'] }}",
                                    "{{ $mocks['today_enrollment']['atma-mock'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)'
                                        }
                                    }
                                },
                                // markLine: {
                                //     data: [{
                                //         type: 'average',
                                //         name: 'Average'
                                //     }],
                                //     label: {
                                //         color: 'var(--body-color)'
                                //     }
                                // }
                            }
                        ]
                    });
                }


                //
                // Resize charts
                //

                // Resize function
                var triggerChartResize = function() {
                    columns_basic_element && columns_basic.resize();
                };

                // On sidebar width change
                var sidebarToggle = document.querySelectorAll('.sidebar-control');
                if (sidebarToggle) {
                    sidebarToggle.forEach(function(togglers) {
                        togglers.addEventListener('click', triggerChartResize);
                    });
                }

                // On window resize
                var resizeCharts;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeCharts);
                    resizeCharts = setTimeout(function() {
                        triggerChartResize();
                    }, 200);
                });
            };

            return {
                init: function() {
                    _columnsBasicLightExample();
                }
            }
        }();

        EchartsTotalRevenue.init();
        EchartsNoOfEnrollment.init();

    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total Revenue</h5>
                {{--  <span class="mx-2 ">6410</span>
                <span class="text-success ">+5.01% <i class="ph-trend-up me-2"></i></span>  --}}
                <span class="mx-3">{{ $mocks['total_revenue']['sum'] }}</span>
                @if ($mocks['total_revenue']['per'] > 0)
                    <span class="text-success ms-2">{{ number_format($mocks['total_revenue']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($mocks['total_revenue']['per'] < 0)
                    <span class="text-danger ms-2">{{ number_format($mocks['total_revenue']['per'], 2) }}% <i
                            class="ph-trend-down me-2"></i></span>
                @else
                    <span class="text-info ms-2">0.00%</span>
                @endif
                <div class="ms-auto ">
                    <div class="d-flex align-items-center text-muted fs-sm">
                        <span class="bg-primary rounded-pill p-1 me-1"></span>Today
                        <span class="bg-primary-2 rounded-pill p-1 mx-1"></span>Last Day
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="total_revenue"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">No Of Enrollment</h5>
                {{--  <span class="mx-2 ">51</span>
                <span class="text-success ">+2.01% <i class="ph-trend-up me-2"></i></span>  --}}
                <span class="mx-3">{{ $mocks['enrollment']['count'] }}</span>
                @if ($mocks['enrollment']['per'] > 0)
                    <span class="text-success ms-2">{{ number_format($mocks['enrollment']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($mocks['enrollment']['per'] < 0)
                    <span class="text-danger ms-2">{{ number_format($mocks['enrollment']['per'], 2) }}% <i
                            class="ph-trend-down me-2"></i></span>
                @else
                    <span class="text-info ms-2">0.00%</span>
                @endif
                <div class="ms-auto ">
                    <div class="d-flex align-items-center text-muted fs-sm">
                        <span class="bg-enrollment rounded-pill p-1 me-1"></span>Today
                        <span class="bg-enrollment-3 rounded-pill p-1 mx-1"></span>Last Day
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="no_of_enrollment"></div>
                </div>
            </div>
        </div>
    </div>
</div>
