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
                        // color: ['rgba(var(--primary-rgb), 0.5)', 'rgba(var(--primary-rgb), 1)'],

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
                                'CAT 2023 Intensive Course  (CAT,XAT,NMAT,SNAP etc)',
                                'CAT 2023 Turbo Course',
                                'CAT 2023 Self-Study Course',
                                'CAT Intensive 2024 (Inc. CAT, XAT, NMAT, SNAP)',
                                {{-- 'CAT  2024 + GMAT', --}}
                                'CAT Course Non-engineers (10th & 12th both above 9...)',
                                'Books & Mocks Course',
                                'Quants Course',
                                'Verbal Ability Course',
                                'DI LR Course',
                                'CAT Course for Repeaters (above 95%tile last year)',
                                'CAT Course for Repeaters (90-95%tile)',
                                'CAT Course for Repeaters (80-90%tile)',
                                'CAT Course for Repeaters (Less than 80%tile)',
                                'CAT Course for IIT/NIT',
                                'CAT Turbo 2024',
                                'CAT Self Study 2024',
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
                                // data: [9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 7.0,
                                //     23.2, 25.6,
                                //     76.7, 135.6, 162.2, 32.6, 20.0
                                // ],
                                data: [
                                    "{{ $cat['last_day_revenue']['cat-course'] }}",
                                    "{{ $cat['last_day_revenue']['cat-2023-turbo-course'] }}",
                                    "{{ $cat['last_day_revenue']['cat-2023-self-study-course'] }}",                                    
                                    "{{ $cat['last_day_revenue']['cat-intensive'] }}",
                                    {{-- "{{ $cat['last_day_revenue']['cat-2024-gmat-combo'] }}", --}}
                                    "{{ $cat['last_day_revenue']['cat-non-engineers'] }}",
                                    "{{ $cat['last_day_revenue']['books-and-mocks'] }}",
                                    "{{ $cat['last_day_revenue']['quants-course'] }}",
                                    "{{ $cat['last_day_revenue']['verbal-ability-course'] }}",
                                    "{{ $cat['last_day_revenue']['dilr-courses'] }}",
                                    "{{ $cat['last_day_revenue']['cat-for-repeaters'] }}",
                                    "{{ $cat['last_day_revenue']['repeaters-90-to-95'] }}",
                                    "{{ $cat['last_day_revenue']['repeaters-80-to-90'] }}",
                                    "{{ $cat['last_day_revenue']['repeaters-80'] }}",
                                    "{{ $cat['last_day_revenue']['cat-for-iit-nit'] }}",
                                    "{{ $cat['last_day_revenue']['cat-turbo-2024'] }}",
                                    "{{ $cat['last_day_revenue']['cat-self-study'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            // verticalAlign: 'middle',
                                            // distance:20,
                                            // rotate: 90,
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
                                    "{{ $cat['today_revenue']['cat-course'] }}",
                                    "{{ $cat['today_revenue']['cat-2023-turbo-course'] }}",
                                    "{{ $cat['today_revenue']['cat-2023-self-study-course'] }}",                                    
                                    "{{ $cat['today_revenue']['cat-intensive'] }}",
                                    {{-- "{{ $cat['today_revenue']['cat-2024-gmat-combo'] }}", --}}
                                    "{{ $cat['today_revenue']['cat-non-engineers'] }}",
                                    "{{ $cat['today_revenue']['books-and-mocks'] }}",
                                    "{{ $cat['today_revenue']['quants-course'] }}",
                                    "{{ $cat['today_revenue']['verbal-ability-course'] }}",
                                    "{{ $cat['today_revenue']['dilr-courses'] }}",
                                    "{{ $cat['today_revenue']['cat-for-repeaters'] }}",
                                    "{{ $cat['today_revenue']['repeaters-90-to-95'] }}",
                                    "{{ $cat['today_revenue']['repeaters-80-to-90'] }}",
                                    "{{ $cat['today_revenue']['repeaters-80'] }}",
                                    "{{ $cat['today_revenue']['cat-for-iit-nit'] }}",
                                    "{{ $cat['today_revenue']['cat-turbo-2024'] }}",
                                    "{{ $cat['today_revenue']['cat-self-study'] }}",
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: false,
                                            position: 'top',
                                            // rotate: 90,
                                            // distance:20,
                                            // verticalAlign: 'middle',
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
                        // color: ['#0280FC2E', '#328FEA'],--enrollment-rgb
                        color: ['#6186FF4D', '#6186FF'],
                        // color: ['rgba(var(--enrollment-rgb), 0.5)',
                        //     'rgba(var(--enrollment-rgb), 1)'
                        // ],

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
                                'CAT 2023 Intensive Course  (CAT,XAT,NMAT,SNAP etc)',
                                'CAT 2023 Turbo Course',
                                'CAT 2023 Self-Study Course',
                                'CAT Intensive 2024 (Inc. CAT, XAT, NMAT, SNAP)',
                                {{-- 'CAT  2024 + GMAT', --}}
                                'CAT Course Non-engineers (10th & 12th both above 9...)',
                                'Books & Mocks Course',
                                'Quants Course',
                                'Verbal Ability Course',
                                'DI LR Course',
                                'CAT Course for Repeaters (above 95%tile last year)',
                                'CAT Course for Repeaters (90-95%tile)',
                                'CAT Course for Repeaters (80-90%tile)',
                                'CAT Course for Repeaters (Less than 80%tile)',
                                'CAT Course for IIT/NIT',
                                'CAT Turbo 2024',
                                'CAT Self Study 2024',
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
                                    "{{ $cat['last_day_enrollment']['cat-course'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-2023-turbo-course'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-2023-self-study-course'] }}",                                    
                                    "{{ $cat['last_day_enrollment']['cat-intensive'] }}",
                                    {{-- "{{ $cat['last_day_enrollment']['cat-2024-gmat-combo'] }}", --}}
                                    "{{ $cat['last_day_enrollment']['cat-non-engineers'] }}",
                                    "{{ $cat['last_day_enrollment']['books-and-mocks'] }}",
                                    "{{ $cat['last_day_enrollment']['quants-course'] }}",
                                    "{{ $cat['last_day_enrollment']['verbal-ability-course'] }}",
                                    "{{ $cat['last_day_enrollment']['dilr-courses'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-for-repeaters'] }}",
                                    "{{ $cat['last_day_enrollment']['repeaters-90-to-95'] }}",
                                    "{{ $cat['last_day_enrollment']['repeaters-80-to-90'] }}",
                                    "{{ $cat['last_day_enrollment']['repeaters-80'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-for-iit-nit'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-turbo-2024'] }}",
                                    "{{ $cat['last_day_enrollment']['cat-self-study'] }}",
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
                                    "{{ $cat['today_enrollment']['cat-course'] }}",
                                    "{{ $cat['today_enrollment']['cat-2023-turbo-course'] }}",
                                    "{{ $cat['today_enrollment']['cat-2023-self-study-course'] }}",                                    
                                    "{{ $cat['today_enrollment']['cat-intensive'] }}",
                                    {{-- "{{ $cat['today_enrollment']['cat-2024-gmat-combo'] }}", --}}
                                    "{{ $cat['today_enrollment']['cat-non-engineers'] }}",
                                    "{{ $cat['today_enrollment']['books-and-mocks'] }}",
                                    "{{ $cat['today_enrollment']['quants-course'] }}",
                                    "{{ $cat['today_enrollment']['verbal-ability-course'] }}",
                                    "{{ $cat['today_enrollment']['dilr-courses'] }}",
                                    "{{ $cat['today_enrollment']['cat-for-repeaters'] }}",
                                    "{{ $cat['today_enrollment']['repeaters-90-to-95'] }}",
                                    "{{ $cat['today_enrollment']['repeaters-80-to-90'] }}",
                                    "{{ $cat['today_enrollment']['repeaters-80'] }}",
                                    "{{ $cat['today_enrollment']['cat-for-iit-nit'] }}",
                                    "{{ $cat['today_enrollment']['cat-turbo-2024'] }}",
                                    "{{ $cat['today_enrollment']['cat-self-study'] }}",
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
                <span class="mx-3">{{ $cat['total_revenue']['sum'] }}</span>
                @if ($cat['total_revenue']['per'] > 0)
                    <span class="text-success ms-2">{{ numberFormat($cat['total_revenue']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($cat['total_revenue']['per'] < 0)
                    <span class="text-danger ms-2">{{ numberFormat($cat['total_revenue']['per'], 2) }}% <i
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
                <span class="mx-3">{{ $cat['enrollment']['count'] }}</span>
                @if ($cat['enrollment']['per'] > 0)
                    <span class="text-success ms-2">{{ numberFormat($cat['enrollment']['per'], 2) }}% <i
                            class="ph-trend-up me-2"></i></span>
                @elseif($cat['enrollment']['per'] < 0)
                    <span class="text-danger ms-2">{{ numberFormat($cat['enrollment']['per'], 2) }}% <i
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
