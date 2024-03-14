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
                                'IELTS Intensive (Academic)',
                                'GMAT Turbo',
                                'GMAT + IELTS + Application',
                                'GRE Turbo',
                                'IELTS Intensive (General)',
                                'CAT + GMAT',
                                'CAT + GRE',
                                'CAT  2024 + GMAT',
                                'IELTS + Applications',
                                'GMAT - Intensive (GAP Program)',
                                'GRE Intensive - GAP Program',
                                'CAT + GMAT + Applications',
                                'IELTS Turbo (Academic)'
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
                                    "{{ $studyAbroad['last_day_revenue']['ielts-course'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['gmat-course'] }}",                                    
                                    "{{ $studyAbroad['last_day_revenue']['gmat-ielts-application'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['gre-course'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['ielts-general-intensive'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['cat-gmat'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['cat-gre'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['cat-2024-gmat-combo'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['ielts-applications'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['gmat-courses'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['gre-courses'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['cat-gmat-applications'] }}",
                                    "{{ $studyAbroad['last_day_revenue']['ielts-courses'] }}",
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
                                // data: [7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 9.0,
                                //     26.4, 58.7,
                                //     70.7, 175.6, 182.2, 48.7, 18.8
                                // ],
                                data: [
                                    "{{ $studyAbroad['today_revenue']['ielts-course'] }}",
                                    "{{ $studyAbroad['today_revenue']['gmat-course'] }}",                                    
                                    "{{ $studyAbroad['today_revenue']['gmat-ielts-application'] }}",
                                    "{{ $studyAbroad['today_revenue']['gre-course'] }}",
                                    "{{ $studyAbroad['today_revenue']['ielts-general-intensive'] }}",
                                    "{{ $studyAbroad['today_revenue']['cat-gmat'] }}",
                                    "{{ $studyAbroad['today_revenue']['cat-gre'] }}",
                                    "{{ $studyAbroad['today_revenue']['cat-2024-gmat-combo'] }}",
                                    "{{ $studyAbroad['today_revenue']['ielts-applications'] }}",
                                    "{{ $studyAbroad['today_revenue']['gmat-courses'] }}",
                                    "{{ $studyAbroad['today_revenue']['gre-courses'] }}",
                                    "{{ $studyAbroad['today_revenue']['cat-gmat-applications'] }}",
                                    "{{ $studyAbroad['today_revenue']['ielts-courses'] }}",
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
                            // data: ['Direct', 'Website', 'Sales Team', 'Ads',
                            //     'Free Cat Mocks',
                            //     'Free NMAT Mocks', 'Free CAT Works hops',
                            //     'Already Entrolled Other Institute',
                            //     'Intersted In EMI',
                            //     'Interested In Course Or Call Back Requests',
                            //     'NAIs Chat',
                            //     'Freebies On Website', 'Sulekha'
                            // ],
                            data: [
                                'IELTS Intensive (Academic)',
                                'GMAT Turbo',
                                'GMAT + IELTS + Application',
                                'GRE Turbo',
                                'IELTS Intensive (General)',
                                'CAT + GMAT',
                                'CAT + GRE',
                                'CAT  2024 + GMAT',
                                'IELTS + Applications',
                                'GMAT - Intensive (GAP Program)',
                                'GRE Intensive - GAP Program',
                                'CAT + GMAT + Applications',
                                'IELTS Turbo (Academic)'
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
                                // data: [7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 9.0,
                                //     26.4, 58.7,
                                //     70.7, 175.6, 182.2, 48.7, 18.8
                                // ],
                                data: [
                                    "{{ $studyAbroad['last_day_enrollment']['ielts-course'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['gmat-course'] }}",                                    
                                    "{{ $studyAbroad['last_day_enrollment']['gmat-ielts-application'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['gre-course'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['ielts-general-intensive'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['cat-gmat'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['cat-gre'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['cat-2024-gmat-combo'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['ielts-applications'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['gmat-courses'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['gre-courses'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['cat-gmat-applications'] }}",
                                    "{{ $studyAbroad['last_day_enrollment']['ielts-courses'] }}",
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
                                // data: [9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 7.0,
                                //     23.2, 25.6,
                                //     76.7, 135.6, 162.2, 32.6, 20.0
                                // ],
                                data: [
                                    "{{ $studyAbroad['today_enrollment']['ielts-course'] }}",
                                    "{{ $studyAbroad['today_enrollment']['gmat-course'] }}",                                    
                                    "{{ $studyAbroad['today_enrollment']['gmat-ielts-application'] }}",
                                    "{{ $studyAbroad['today_enrollment']['gre-course'] }}",
                                    "{{ $studyAbroad['today_enrollment']['ielts-general-intensive'] }}",
                                    "{{ $studyAbroad['today_enrollment']['cat-gmat'] }}",
                                    "{{ $studyAbroad['today_enrollment']['cat-gre'] }}",
                                    "{{ $studyAbroad['today_enrollment']['cat-2024-gmat-combo'] }}",
                                    "{{ $studyAbroad['today_enrollment']['ielts-applications'] }}",
                                    "{{ $studyAbroad['today_enrollment']['gmat-courses'] }}",
                                    "{{ $studyAbroad['today_enrollment']['gre-courses'] }}",
                                    "{{ $studyAbroad['today_enrollment']['cat-gmat-applications'] }}",
                                    "{{ $studyAbroad['today_enrollment']['ielts-courses'] }}",
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
                <span class="mx-3">{{ $studyAbroad['total_revenue']['sum'] }}</span>
                @if ($studyAbroad['total_revenue']['per'] > 0)
                    <span class="text-success ms-2">{{ number_format($studyAbroad['total_revenue']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($studyAbroad['total_revenue']['per'] < 0)
                    <span class="text-danger ms-2">{{ number_format($studyAbroad['total_revenue']['per'], 2) }}% <i
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
                <span class="mx-3">{{ $studyAbroad['enrollment']['count'] }}</span>
                @if ($studyAbroad['enrollment']['per'] > 0)
                    <span class="text-success ms-2">{{ number_format($studyAbroad['enrollment']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($studyAbroad['enrollment']['per'] < 0)
                    <span class="text-danger ms-2">{{ number_format($studyAbroad['enrollment']['per'], 2) }}% <i
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
