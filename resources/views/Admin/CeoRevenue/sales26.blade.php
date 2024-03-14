<script>
    $(document).ready(function() {

        var EchartsConversionColumnsBasicLight = function() {
            var _columnsBasicLightExample = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var columns_basic_element = document.getElementById('conversion_ratio');

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
                                var tooltip = '' + params[0]
                                    .name;
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
                                tooltip +=
                                    '</p><p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary-2 align-items-center rounded-pill p-1 me-1"></span>Last Day<span class="ms-3"><b>' +
                                    params[0].value.toLocaleString('en-US', {
                                        style: 'decimal'
                                    }) + '</b></span></p>';
                                tooltip +=
                                    '<p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary align-items-center rounded-pill p-1 me-1"></span>Today<span class="ms-4 ps-1"><b>' +
                                    params[1].value.toLocaleString('en-US', {
                                        style: 'decimal'
                                    }) + '</b></span></p>';
                                return tooltip;
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: ['Direct', 'Website', 'Sales team', 'Ads',
                                'Free cat mocks',
                                'Free nmat mocks', 'Free cat works hops',
                                'Already entrolled other institute',
                                'Intersted in EMI',
                                'Interested in course or call back requests',
                                'NAIs chat',
                                'Freebies on website', 'Sulekha'
                            ],
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)',
                                rotate: 30,
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
                                color: 'rgba(var(--body-color-rgb), .65)',
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
                                name: 'Leads',
                                type: 'bar',
                                data: [7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 9.0,
                                    26.4, 58.7,
                                    70.7, 175.6, 182.2, 48.7, 18.8
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: true,
                                            distance: -5,
                                            rotate: 90,
                                            bottom: 15,
                                            align: 'left',
                                            verticalAlign: 'middle',
                                            position: 'bottom',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)',
                                            formatter: function(d) {
                                                return d.data.toLocaleString('en-US', {
                                                    style: 'decimal'
                                                });
                                            }
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
                                name: 'Conversion Leads',
                                type: 'bar',
                                data: [9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 7.0,
                                    23.2, 25.6,
                                    76.7, 135.6, 162.2, 32.6, 20.0
                                ],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: true,
                                            distance: -5,
                                            rotate: 90,
                                            bottom: 15,
                                            align: 'left',
                                            verticalAlign: 'middle',
                                            position: 'bottom',
                                            fontWeight: 500,
                                            fontSize: 12,
                                            color: 'var(--body-color)',
                                            formatter: function(d) {
                                                return d.data.toLocaleString('en-US', {
                                                    style: 'decimal'
                                                });
                                            }
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

        var EchartsCallColumnsBasicLight = function() {
            var _columnsBasicLightExample = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var columns_basic_element = document.getElementById('call_hour_flow');

                if (columns_basic_element) {

                    // Initialize chart
                    var columns_basic = echarts.init(columns_basic_element, null, {
                        renderer: 'svg'
                    });

                    columns_basic.setOption({

                        // Define colors
                        color: ['#88A4FF'],

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
                            }
                        },

                        // Horizontal axis
                        xAxis: [{
                            type: 'category',
                            data: ['10 AM', '11 AM', '12 PM', '1 PM', '2 PM', '3 PM',
                                '4 PM',
                                '5 PM', '6 PM', '7 PM'
                            ],
                            axisLabel: {
                                color: 'rgba(var(--body-color-rgb), .65)',
                                rotate: 30,
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
                                name: 'Call Hour Flow',
                                type: 'bar',
                                data: [33, 59, 50, 30, 70, 85, 65, 87, 64, 33],
                                itemStyle: {
                                    normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                        label: {
                                            show: true,
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

        var EchartsPieDonutLight = function() {

            var _scatterPieDonutLightExample = function() {
                if (typeof echarts == 'undefined') {
                    console.warn('Warning - echarts.min.js is not loaded.');
                    return;
                }

                // Define element
                var pie_donut_element = document.getElementById('total_missed_calls');


                //
                // Charts configuration
                //

                if (pie_donut_element) {

                    // Initialize chart
                    var pie_donut = echarts.init(pie_donut_element, null, {
                        renderer: 'svg'
                    });


                    //
                    // Chart config
                    //

                    // Options
                    pie_donut.setOption({

                        // Colors
                        color: [
                            '#6186FF', '#92ACFF', '#C7D2F4'
                        ],

                        // Global text styles
                        textStyle: {
                            fontFamily: 'var(--body-font-family)',
                            color: 'var(--body-color)',
                            fontSize: 14,
                            lineHeight: 52,
                            textBorderColor: 'transparent'
                        },

                        // Add tooltip
                        tooltip: {
                            trigger: 'item',
                            className: 'shadow-sm rounded',
                            backgroundColor: 'var(--white)',
                            borderColor: 'var(--gray-400)',
                            padding: 5,
                            textStyle: {
                                color: '#000'
                            },
                            formatter: "<b>{c}</b> <br>({d}%)"
                        },

                        // Add legend
                        legend: {
                            orient: 'vertical',
                            right: 0,
                            top: 'center',
                            data: ['Agent disconnect', 'Caller disconnect',
                                'System disconnect'
                            ],
                            itemHeight: 8,
                            itemWidth: 8,
                            textStyle: {
                                color: 'var(--body-color)'
                            },
                            itemStyle: {
                                borderColor: 'transparent'
                            }
                        },

                        // Add series
                        series: [{
                            name: 'Total Missed Calls',
                            type: 'pie',
                            radius: ['50%', '70%'],
                            center: ['40%', '50%'],
                            itemStyle: {
                                borderColor: 'var(--card-bg)'
                            },
                            label: {
                                show: false,
                                color: 'var(--body-color)',
                            },
                            data: [{
                                    value: 25,
                                    name: 'Agent disconnect'
                                },
                                {
                                    value: 18,
                                    name: 'Caller disconnect'
                                },
                                {
                                    value: 7,
                                    name: 'System disconnect'
                                },
                            ]
                        }]
                    });
                }


                //
                // Resize charts
                //

                // Resize function
                var triggerChartResize = function() {
                    pie_donut_element && pie_donut.resize();
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


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _scatterPieDonutLightExample();
                }
            }
        }();

        EchartsConversionColumnsBasicLight.init();
        EchartsCallColumnsBasicLight.init();
        EchartsPieDonutLight.init();

        $('[data-bs-popup="tooltip"]').tooltip();

        $('.custom-tooltip').tooltip({
            html: true, // Enable HTML content in the tooltip
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner bg-info"><p></p></div></div>',
        });

        // Add an event listener to underline the tooltip text
        $('.custom-tooltip').on('shown.bs.tooltip', function() {
            $('.tooltip-inner').html(
                '<h5>Untouched Leads</h5><table class="table mt-0 text-white"><tr><td>Victoria</td><td>2</td></tr><tr><td>James</td><td>3</td></tr></table>'
            );
        });
    });
</script>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total calls</h5>
                <div class="ms-auto">
                    <span class="me-1 badge bg-primary rounded-pill">826</span>
                    <i class="ph-info ms-1" data-bs-popup="tooltip"
                        title="Details of total calls, including how many were answered and how many went unanswered"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Total connected calls </td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Total unanswered incoming calls</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Leads</h5>
                <div class="ms-auto">
                    <i class="ph-info ms-1 custom-tooltip" data-bs-popup="tooltip" title="Untouched Leads"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Total leads </td>
                            <td>{{ $sales['total_lead'] }}</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>Untouched leads</td>
                            <td class="text-danger">{{ $sales['untouched_lead'] }}</td>
                            <td class="text-danger">{{ $sales['untouched_lead_per'] }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Converted leads</h5>
                <div class="ms-auto">
                    <i class="ph-info ms-1" data-bs-popup="tooltip"
                        title="information about converted leads from agent-based and direct sources"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Agent based leads</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Direct leads</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Inbound calls </h5><i class="ph-phone-incoming ms-2"></i>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Incoming Calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Total calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Incoming Calls That were connected"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-phone-volume "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Connected calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Incoming Calls That were Missed"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-x"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Missed calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="total number of calls that are in waiting in queue to connect"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-outgoing "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Calls queue</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Overall Number of Hours All Agents Talked Throughout the Day on inbound calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-clock"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Duration hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Avereage Time in minutes that all agents spent on the inbound calls."></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-hourglass-half"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Avg duration in min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Number Of Agents available for inbound calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="far fa-user"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Number of agents</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Outbound calls </h5>
                <i class="ph-phone-outgoing ms-2"></i>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Outgoing Calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Total calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Outgoing Calls That were connected"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-phone-volume "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Connected calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Outgoing Calls That were Unanswered"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-x"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Unanswered calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="total number of calls that are in waiting in queue to connect"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-outgoing "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Calls queue</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Overall Number of Hours All Agents Talked Throughout the Day on outbound calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-hourglass-half"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Duration hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Average Time in minutes that all agents spent on the Outbound calls."></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-hourglass-half"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Avg duration in min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Number Of Agents available for Outbound calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="far fa-user"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Number of agents</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Progressive calls </h5>
                <i class="ph-phone-outgoing ms-2"></i>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Progressive Calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Total calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Progressive Calls That were connected"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-phone-volume "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Connected calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total Number of Progressive Calls That were Unanswered"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-x"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Missed calls</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Total number of calls that are in waiting in queue to connect"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="ph-phone-outgoing "></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Calls queue</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Overall Number of Hours All Agents Talked Throughout the Day on Progressive calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-hourglass-half"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Duration hrs</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Average Time in minutes that all agents spent on the Progressive calls."></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="fas fa-hourglass-half"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Avg duration in min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6  col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto">
                                    <div class="d-flex justify-content-end ">
                                        <i class="ph-info ms-1" data-bs-popup="tooltip"
                                            title="Number Of Agents available for Progressive calls"></i>
                                    </div>
                                    <div class="d-flex align-items-center mb-lg-0">
                                        <a href="#"
                                            class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                            <i class="far fa-user"></i>
                                        </a>
                                        <div class="ms-3">
                                            <h5 class="mb-0">0</h5>
                                            <span class="text-muted">Number of agents</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Conversion ratio</h5>
                <div class="ms-auto">
                    <div class="d-flex align-items-center text-muted fs-sm">
                        <span class="bg-primary rounded-pill p-1 me-2"></span>Leads
                        <span class="bg-primary-2 rounded-pill p-1 mx-2"></span>Conversion Leads
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="conversion_ratio"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Call Hour Flow <span class="float-end badge bg-enrollment rounded-pill">576
                    </span></h5>

            </div>

            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="call_hour_flow"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Per agent conversion</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-xxs">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Agent name</th>
                            <th>Leads</th>
                            <th>Converted leads</th>
                            <th>Untouched leads</th>
                            <th>Avg talk time</th>
                            <th>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-block bg-primary rounded-pill p-1 me-1"></span>
                                    Connected calls
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-block bg-primary-2 rounded-pill p-1 me-1"></span>
                                    Disconnected calls
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>0</span>
                                    <span>5</span>
                                    <span>10</span>
                                    <span>15</span>
                                    <span>20</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="active bg-enrollment-5">
                            <td>01</td>
                            <td>Deeksha kapoor</td>
                            <td>17</td>
                            <td>12</td>
                            <td class="text-danger">5</td>
                            <td>11.6 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 10 * 5 }}%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">10%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width:  {{ 10 * 5 }}%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="20">
                                        <span>10%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>Farnaz khan</td>
                            <td>17</td>
                            <td>11</td>
                            <td class="text-danger">16</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 7 * 5 }}%"
                                        aria-valuenow="7" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">7%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 18 * 5 }}%"
                                        aria-valuenow="18" aria-valuemin="0" aria-valuemax="20">
                                        <span>18%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>03</td>
                            <td>Vanshita hiranandi</td>
                            <td>15</td>
                            <td>10</td>
                            <td class="text-danger">5</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 9 * 5 }}%"
                                        aria-valuenow="9" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">9%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 15 * 5 }}%"
                                        aria-valuenow="15" aria-valuemin="0" aria-valuemax="20">
                                        <span>15%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>04</td>
                            <td>Deeksha kapoor</td>
                            <td>17</td>
                            <td>12</td>
                            <td class="text-danger">5</td>
                            <td>11.6 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 3 * 5 }}%"
                                        aria-valuenow="3" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">3%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 14 * 5 }}%"
                                        aria-valuenow="14" aria-valuemin="0" aria-valuemax="20">
                                        <span>14%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>05</td>
                            <td>Farnaz khan</td>
                            <td>17</td>
                            <td>11</td>
                            <td class="text-danger">16</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 7 * 5 }}%"
                                        aria-valuenow="7" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">7%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 18 * 5 }}%"
                                        aria-valuenow="18" aria-valuemin="0" aria-valuemax="20">
                                        <span>18%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>06</td>
                            <td>Vanshita hiranandi</td>
                            <td>15</td>
                            <td>10</td>
                            <td class="text-danger">5</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 9 * 5 }}%"
                                        aria-valuenow="9" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">9%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 15 * 5 }}%"
                                        aria-valuenow="15" aria-valuemin="0" aria-valuemax="20">
                                        <span>15%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>07</td>
                            <td>Deeksha kapoor</td>
                            <td>17</td>
                            <td>12</td>
                            <td class="text-danger">5</td>
                            <td>11.6 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 11 * 5 }}%"
                                        aria-valuenow="11" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">11%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 12 * 5 }}%"
                                        aria-valuenow="12" aria-valuemin="0" aria-valuemax="20">
                                        <span>12%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>08</td>
                            <td>Farnaz khan</td>
                            <td>17</td>
                            <td>11</td>
                            <td class="text-danger">16</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 7 * 5 }}%"
                                        aria-valuenow="7" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">7%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 17 * 5 }}%"
                                        aria-valuenow="17" aria-valuemin="0" aria-valuemax="20">
                                        <span>17%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>09</td>
                            <td>Vanshita hiranandi</td>
                            <td>15</td>
                            <td>10</td>
                            <td class="text-danger">5</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 8 * 5 }}%"
                                        aria-valuenow="8" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">8%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 13 * 5 }}%"
                                        aria-valuenow="13" aria-valuemin="0" aria-valuemax="20">
                                        <span>13%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Deeksha kapoor</td>
                            <td>17</td>
                            <td>12</td>
                            <td class="text-danger">5</td>
                            <td>11.6 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 4 * 5 }}%"
                                        aria-valuenow="4" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">4%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 16 * 5 }}%"
                                        aria-valuenow="16" aria-valuemin="0" aria-valuemax="20">
                                        <span>16%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Farnaz khan</td>
                            <td>17</td>
                            <td>11</td>
                            <td class="text-danger">16</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 6 * 5 }}%"
                                        aria-valuenow="6" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">6%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 17 * 5 }}%"
                                        aria-valuenow="17" aria-valuemin="0" aria-valuemax="20">
                                        <span>17%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Vanshita hiranandi</td>
                            <td>15</td>
                            <td>10</td>
                            <td class="text-danger">5</td>
                            <td>5.5 min</td>
                            <td>
                                <div class="progress mb-1 h-16px">
                                    <div class="progress-bar bg-primary-2" style="width: {{ 11 * 5 }}%"
                                        aria-valuenow="11" aria-valuemin="0" aria-valuemax="20">
                                        <span class="text-primary">11%</span>
                                    </div>
                                </div>
                                <div class="progress h-16px">
                                    <div class="progress-bar bg-primary" style="width: {{ 13 * 5 }}%"
                                        aria-valuenow="13" aria-valuemin="0" aria-valuemax="20">
                                        <span>13%</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Call timing </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Time Of Calls</th>
                        <th>Number Of Calls</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>09:00 AM - 09:00 PM</td>
                            <td>576</td>
                        </tr>
                        <tr>
                            <td>09:00 PM - 09:00 AM<br>
                                (After office hours)
                            </td>
                            <td>120</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total missed calls</h5>
                <div class="ms-auto">
                    <span class="me-1 badge bg-enrollment rounded-pill">50</span>
                    <i class="ph-info ms-1 " data-bs-popup="tooltip" title="Agent Disconnect" data-bs-toggle="modal"
                        data-bs-target="#modal_large"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <div class="chart has-fixed-height" id="total_missed_calls"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Large modal -->
<div id="modal_large" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agent disconnect</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="table-responsive border-radius-15">
                <table class="table table-bordered table-framed">
                    <thead>
                        <tr>
                            <th>Agent name</th>
                            <th>Inbound</th>
                            <th>outbound</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Farnaz khan</td>
                            <td>8</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Seema yadav</td>
                            <td>6</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Prerana panda</td>
                            <td>8</td>
                            <td>4</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /large modal -->
