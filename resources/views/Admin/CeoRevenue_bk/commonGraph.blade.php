@php
$courseArr = json_encode($commonGraph['courses_slug']);
$todayEnrollment = json_encode($commonGraph['today_enrollment']);
$todayRevenue = json_encode($commonGraph['today_revenue']);
$lastDayEnrollment = json_encode($commonGraph['lastDay_enrollment']);
$lastDayRevenue = json_encode($commonGraph['lastDay_revenue']);    
@endphp
<script>
    $(document).ready(function() {
    $('.dashboardShowDate').html("({{ $selectedStartDate }} to {{ $selectedEndDate }})");
            const courseArr = <?php echo $courseArr; ?>;
            const todayEnrollment = <?php echo $todayEnrollment; ?>;
            const todayRevenue = <?php echo $todayRevenue; ?>;
            const lastDayEnrollment = <?php echo $lastDayEnrollment; ?>;
            const lastDayRevenue = <?php echo $lastDayRevenue; ?>;
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
                                    var tooltip = '<span class="text-center">' +
                                            params[1].value.toLocaleString('en-US', {
                                    style: 'decimal'
                                    }) + '</span><br>';
                                            var oldValue = params[0].value > 0 ? params[0].value : 1;
                                            var per = (params[1].value - oldValue) / oldValue *
                                            100;
                                            var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                            params[1].value != 0 ? 100 : 0);
                                            tooltip += percantage > 0 ?
                                            '<span class="text-success text-center">' + percantage +
                                            '% <br><i class="ph-trend-up me-2"></i></span>' : (
                                                    percantage < 0 ?
                                                    '<span class="text-danger text-center">' +
                                                    percantage +
                                                    '% <br><i class="ph-trend-down me-2"></i></span>' :
                                                    '<span class="text-info text-center">' +
                                                    percantage +
                                                    '% </span>');
                                            return tooltip;
                                    },
                                    // formatter: function(params) {
                                    //     var tooltip = '' + params[0]
                                    //         .name;
                                    //     var oldValue = params[0].value > 0 ? params[0].value : 1;
                                    //     var per = (params[1].value - oldValue) / oldValue *
                                    //         100;
                                    //     var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                    //         params[1].value != 0 ? 100 : 0);
                                    //     tooltip += percantage > 0 ?
                                    //         '<span class="text-success ms-2">' + percantage +
                                    //         '% <i class="ph-trend-up me-2"></i></span>' : (
                                    //             percantage < 0 ? '<span class="text-danger ms-2">' +
                                    //             percantage +
                                    //             '% <i class="ph-trend-down me-2"></i></span>' :
                                    //             '<span class="text-info ms-2">' +
                                    //             percantage +
                                    //             '% </span>');
                                    //     tooltip +=
                                    //         '</p><p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary-2 align-items-center rounded-pill p-1 me-1"></span>Last Day<span class="ms-3"><b>' +
                                    //         params[0].value.toLocaleString('en-US', {
                                    //             style: 'decimal'
                                    //         }) + '</b></span></p>';
                                    //     tooltip +=
                                    //         '<p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary align-items-center rounded-pill p-1 me-1"></span>Today<span class="ms-4 ps-1"><b>' +
                                    //         params[1].value.toLocaleString('en-US', {
                                    //             style: 'decimal'
                                    //         }) + '</b></span></p>';
                                    //     return tooltip;
                                    // }
                            },
                            // Horizontal axis
                            xAxis: [{
                            type: 'category',
                                    data: courseArr,
                                    axisLabel: {
                                    color: 'rgba(var(--body-color-rgb), 1)',
                                            rotate: 30,
                                            fontWeight: 'bold'
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
                            name: 'Last Day',
                                    type: 'bar',
                                    // data: [9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 7.0,
                                    //     23.2, 25.6,
                                    //     76.7, 135.6, 162.2, 32.6, 20.0
                                    // ],
                                    data: lastDayRevenue,
                                    itemStyle: {
                                    normal: {
                                    barBorderRadius: [4, 4, 0, 0],
                                            label: {
                                            show: false,
                                                    // position: 'top',
                                                    // verticalAlign: 'middle',
                                                    // distance:20,
                                                    // rotate: 90,
                                                    distance: - 5,
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
                            }, {
                            name: 'Today',
                                    type: 'bar',
                                    // data: [7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 9.0,
                                    //     26.4, 58.7,
                                    //     70.7, 175.6, 182.2, 48.7, 18.8
                                    // ],
                                    data: todayRevenue,
                                    itemStyle: {
                                    normal: {
                                    barBorderRadius: [4, 4, 0, 0],
                                            label: {
                                            show: true,
                                                    // position: 'top',
                                                    // rotate: 90,
                                                    // distance:20,
                                                    // verticalAlign: 'middle',
                                                    position: 'top',
                                                    distance: 10,
                                                    verticalAlign: 'middle',
                                                    // distance: -5,
                                                    // rotate: 90,
                                                    // bottom: 15,
                                                    // align: 'left',
                                                    // verticalAlign: 'middle',
                                                    // position: 'bottom',
                                                    // fontWeight: 500,
                                                    // fontSize: 12,
                                                    // color: 'var(--body-color)',
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
                            }, ]
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
                            left: 30,
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
                                    var tooltip = '<span class="text-center">' +
                                            params[1].value.toLocaleString('en-US', {
                                    style: 'decimal'
                                    }) + '</span><br>';
                                            var oldValue = params[0].value > 0 ? params[0].value : 1;
                                            var per = (params[1].value - oldValue) / oldValue *
                                            100;
                                            var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                            params[1].value != 0 ? 100 : 0);
                                            tooltip += percantage > 0 ?
                                            '<span class="text-success text-center">' + percantage +
                                            '% <br><i class="ph-trend-up me-2"></i></span>' : (
                                                    percantage < 0 ?
                                                    '<span class="text-danger text-center">' +
                                                    percantage +
                                                    '% <br><i class="ph-trend-down me-2"></i></span>' :
                                                    '<span class="text-info text-center">' +
                                                    percantage +
                                                    '% </span>');
                                            return tooltip;
                                    },
                                    // formatter: function(params) {
                                    //     var tooltip = '' + params[0]
                                    //         .name;
                                    //     var oldValue = params[0].value > 0 ? params[0].value : 1;
                                    //     var per = (params[1].value - oldValue) / oldValue *
                                    //         100;
                                    //     var percantage = params[0].value != 0 ? per.toFixed(2) : (
                                    //         params[1].value != 0 ? 100 : 0);
                                    //     tooltip += percantage > 0 ?
                                    //         '<span class="text-success ms-2">' + percantage +
                                    //         '% <i class="ph-trend-up me-2"></i></span>' : (
                                    //             percantage < 0 ? '<span class="text-danger ms-2">' +
                                    //             percantage +
                                    //             '% <i class="ph-trend-down me-2"></i></span>' :
                                    //             '<span class="text-info ms-2">' +
                                    //             percantage +
                                    //             '% </span>');
                                    //     tooltip +=
                                    //         '</p><p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary-2 align-items-center rounded-pill p-1 me-1"></span>Last Day<span class="ms-3"><b>' +
                                    //         params[0].value.toLocaleString('en-US', {
                                    //             style: 'decimal'
                                    //         }) + '</b></span></p>';
                                    //     tooltip +=
                                    //         '<p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary align-items-center rounded-pill p-1 me-1"></span>Today<span class="ms-4 ps-1"><b>' +
                                    //         params[1].value.toLocaleString('en-US', {
                                    //             style: 'decimal'
                                    //         }) + '</b></span></p>';
                                    //     return tooltip;
                                    // }
                            },
                            // Horizontal axis
                            xAxis: [{
                            type: 'category',
                                    data: courseArr,
                                    axisLabel: {
                                    color: 'rgba(var(--body-color-rgb), 1)',
                                            rotate: 30,
                                            fontWeight: 'bold'
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
                            name: 'Last Day',
                                    type: 'bar',
                                    data: lastDayEnrollment,
                                    itemStyle: {
                                    normal: {
                                    barBorderRadius: [4, 4, 0, 0],
                                            label: {
                                            show: false,
                                                    // position: 'top',
                                                    // fontWeight: 500,
                                                    // fontSize: 12,
                                                    // color: 'var(--body-color)'
                                                    distance: - 5,
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
                            }, {
                            name: 'Today',
                                    type: 'bar',
                                    data: todayEnrollment,
                                    itemStyle: {
                                    normal: {
                                    barBorderRadius: [4, 4, 0, 0],
                                            label: {
                                            show: true,
                                                    // position: 'top',
                                                    // fontWeight: 500,
                                                    // fontSize: 12,
                                                    // color: 'var(--body-color)'
                                                    position: 'top',
                                                    distance: 10,
                                                    verticalAlign: 'middle',
                                                    // distance: -5,
                                                    // rotate: 90,
                                                    // bottom: 15,
                                                    // align: 'left',
                                                    // verticalAlign: 'middle',
                                                    // position: 'bottom',
                                                    // fontWeight: 500,
                                                    // fontSize: 12,
                                                    // color: 'var(--body-color)',
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
                            }]
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
            if (todayRevenue.length > 0 && lastDayRevenue.length > 0) {
    EchartsTotalRevenue.init();
    } else {
    $('#total_revenue').html('<h5>Data not found</h5>');
            $('#total_revenue').addClass('d-flex justify-content-center align-items-center');
    }

    if (todayEnrollment.length > 0 && lastDayEnrollment.length > 0) {
    EchartsNoOfEnrollment.init();
    } else {
    $('#no_of_enrollment').html('<h5>Data not found</h5>');
            $('#no_of_enrollment').addClass('d-flex justify-content-center align-items-center');
    }


    });
</script>
<div class="row">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="fw-semibold mb-0">Statistics</h5>
            @if ($commonGraph['total_today_revenue'] != 0)
            <span class="badge bg-primary rounded-pill mx-2">{{ $commonGraph['total_today_revenue'] }}</span>
            @endif
            @if ($commonGraph['per_today_revenue'] > 0)
            <span class="text-success ms-2">{{ $commonGraph['per_today_revenue'] }}% <i
                    class="ph-trend-up me-2"></i></span>
            @elseif($commonGraph['per_today_revenue'] < 0)
            <span class="text-danger ms-2">{{ $commonGraph['per_today_revenue'] }}% <i
                    class="ph-trend-down me-2"></i></span>
            {{--  @else
                                <span class="text-info ms-2">0.00%</span>  --}}
            @endif            
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Courses</th>
                            <th>Enrollment</th>
                            <th>Revenue</th>                                
                            <th>Last Enrollment</th>
                            <th>Last Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commonGraph['courses_slug'] as $key => $value) { ?>
                            <tr>                                    
                                <td><?= ucfirst(str_replace("-", " ", str_replace("_", " ", $value))) ?></td>                                    
                                <td><?= $commonGraph['today_enrollment'][$key] ?></td>                                    
                                <td><?= number_format($commonGraph['today_revenue'][$key]) ?></td>
                                <td><?= $commonGraph['lastDay_enrollment'][$key] ?></td>
                                <td><?= number_format($commonGraph['lastDay_revenue'][$key]) ?></td>
                            </tr>
                        <?php } ?>                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th><?= array_sum($commonGraph['today_enrollment']) ?></th>
                            <th><?= array_sum($commonGraph['today_revenue']) ?></th>
                            <th><?= array_sum($commonGraph['lastDay_enrollment']) ?></th>
                            <th><?= array_sum($commonGraph['lastDay_revenue']) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div
        class="{{ $commonGraph['selected_course'] == 'undergrad' || $commonGraph['selected_course'] == 'gdpi' ? 'col-lg-6' : 'col-lg-12' }}">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total revenue</h5>
                @if ($commonGraph['total_today_revenue'] != 0)
                <span class="badge bg-primary rounded-pill mx-2">{{ $commonGraph['total_today_revenue'] }}</span>
                @endif
                @if ($commonGraph['per_today_revenue'] > 0)
                <span class="text-success ms-2">{{ $commonGraph['per_today_revenue'] }}% <i
                        class="ph-trend-up me-2"></i></span>
                @elseif($commonGraph['per_today_revenue'] < 0)
                <span class="text-danger ms-2">{{ $commonGraph['per_today_revenue'] }}% <i
                        class="ph-trend-down me-2"></i></span>
                {{--  @else
                                <span class="text-info ms-2">0.00%</span>  --}}
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
    <div
        class="{{ $commonGraph['selected_course'] == 'undergrad' || $commonGraph['selected_course'] == 'gdpi' ? 'col-lg-6' : 'col-lg-12' }}">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">No. of enrollment</h5>
                @if ($commonGraph['total_today_enrollment'] != 0)
                {{--  <span class="mx-3 bg-enrollment-3 rounded p-1">{{ $commonGraph['total_today_enrollment'] }}</span>  --}}
                <span
                    class="badge bg-enrollment rounded-pill mx-2">{{ $commonGraph['total_today_enrollment'] }}</span>
                @endif
                @if ($commonGraph['per_today_enrollment'] > 0)
                <span class="text-success ms-2">{{ $commonGraph['per_today_enrollment'] }}% <i
                        class="ph-trend-up me-2"></i></span>
                @elseif($commonGraph['per_today_enrollment'] < 0)
                <span class="text-danger ms-2">{{ $commonGraph['per_today_enrollment'] }}% <i
                        class="ph-trend-down me-2"></i></span>
                {{--  @else
                    <span class="text-info">0.00%</span>  --}}
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
