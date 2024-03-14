@php
$conversionSource = json_encode($sales['conversionSource']);
$conversionRatioLead = json_encode($sales['conversion_ratio_lead']);
$conversionRatioConversionLead = json_encode($sales['conversion_ratio_conversion_lead']);
@endphp

<script type="text/javascript" src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
        var conversionSource = <?= $conversionSource ?>;
        var conversionRatioLead = <?= $conversionRatioLead ?>;
        var conversionRatioConversionLead = <?= $conversionRatioConversionLead ?>;
        $(function() {
        $.extend($.fn.dataTable.defaults, {
        autoWidth: false,
                columnDefs: [{
                orderable: false,
                        width: '100px',
                        targets: [1]
                }],
                dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                search: '<span>Filter:</span> _INPUT_',
                        lengthMenu: '<span>Show:</span> _MENU_',
                        paginate: {
                        'first': 'First',
                                'last': 'Last',
                                'next': '&rarr;',
                                'previous': '&larr;'
                        }
                },
                drawCallback: function() {
                $(this).find('tbody tr').slice( - 3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                $(this).find('tbody tr').slice( - 3).find('.dropdown, .btn-group').removeClass(
                        'dropup');
                }
        });
                $('.pending-table').DataTable({
        "processing": true,
                "serverSide": true,
                "select": true,
                "ajax": {
                "url": "{{ route('ceo-sales-getData') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": {
                        _token: "{{ csrf_token() }}",
                                startDate: "{{ $startDate }}",
                                endDate: "{{ $endDate }}",
                        }
                },
                "columns": [{
                "data": "DT_RowIndex",
                        "searchable": false,
                        "sortable": false
                },
                {
                "data": "owner",
                },
                {
                "data": "leads",
                },
                {
                "data": "converted"
                },
                {
                "data": "untouched"
                },
                {
                "data": "other_leads"
                },
                {
                "data": "talk_time"
                },
                {
                "data": "progress"
                },
                ]
        });
                $(document).ready(function() {

        var table_data = {
        _token: "{{ csrf_token() }}",
                startDate: "{{ $startDate }}",
                endDate: "{{ $endDate }}",
                date: "{{ $date }}",
                agentdate: $('input[name="agent_date"]:checked').val(),
        };
                var pending1_table = $('#pending1-table').DataTable({
            "processing": true,
                "serverSide": true,
                "select": true,
                "ajax": {
                "url": "{{ route('ceo-sales-getData') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                        return  $.extend(d, table_data);
                        }
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            /* Append the grade to the default row class name */                    
                    $('td:eq(6)', nRow).addClass('warningcolumn');
                    $('td:eq(7)', nRow).addClass('warningcolumn');
                    $('td:eq(8)', nRow).addClass('warningcolumn');
                    $('td:eq(9)', nRow).addClass('warningcolumn');                    
                },
                "columns": [{
                "data": "DT_RowIndex",
                        "searchable": false,
                        "sortable": false
                },
                {
                "data": "owner",
                },
                {
                "data": "leads",
                },
                {
                "data": "converted"
                },
                {
                "data": "convertion_percentage"
                },
                {
                "data": "loss_revenue"
                },                
                {
                "data": "previous_leads"
                },
                {
                "data": "previous_converted"
                },
                {
                "data": "previous_convertion_percentage"
                },
                {
                "data": "previous_loss_revenue"
                }
                
                ]
        });
                $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
                width: 'auto'
        });
                $('input[aria-controls="DataTables_Table_0"]').addClass('rounded ms-2');
                $(".agentselectedDate").click(function(){
        var selectAgentDate = $('input[name="agent_date"]:checked').val();
                table_data = {
                _token: "{{ csrf_token() }}",
                        startDate: "{{ $startDate }}",
                        endDate: "{{ $endDate }}",
                        date: "{{ $date }}",
                        agentdate: $('input[name="agent_date"]:checked').val(),
                };
                pending1_table.ajax.reload();
        });
        });
                $('.dashboardShowDate').html("({{ $selectedStartDate }} to {{ $selectedEndDate }})");
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
                                        {{--  tooltip += percantage > 0 ?
                                                '<span class="text-success ms-2">' + percantage +
                                                '% <i class="ph-trend-up me-2"></i></span>' : (
                                                        percantage < 0 ? '<span class="text-danger ms-2">' +
                                                        percantage +
                                                        '% <i class="ph-trend-down me-2"></i></span>' :
                                                        '<span class="text-info ms-2">' +
                                                        percantage +
                                                        '% </span>'); --}}
                                        tooltip +=
                                                '</p><p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary-2 align-items-center rounded-pill p-1 me-1"></span>Conversion Leads<span class="ms-3"><b>' +
                                                params[0].value.toLocaleString('en-US', {
                                        style: 'decimal'
                                        }) + '</b></span></p>';
                                                tooltip +=
                                                '<p class="d-flex align-items-center text-muted fs-sm"><span class="bg-primary align-items-center rounded-pill p-1 me-1"></span>Leads<span class="ms-4 ps-1"><b>' +
                                                params[1].value.toLocaleString('en-US', {
                                        style: 'decimal'
                                        }) + '</b></span></p>';
                                                return tooltip;
                                        }
                                },
                                // Horizontal axis
                                xAxis: [{
                                type: 'category',
                                        data: conversionSource,
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
                                name: 'Conversion Leads',
                                        type: 'bar',
                                        data: conversionRatioConversionLead,
                                        itemStyle: {
                                        normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                                label: {
                                                show: true,
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
                                },
                                {
                                name: 'Leads',
                                        type: 'bar',
                                        data: conversionRatioLead,
                                        itemStyle: {
                                        normal: {
                                        barBorderRadius: [4, 4, 0, 0],
                                                label: {
                                                show: true,
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
                var callData = <?php echo json_encode($calls['call_hour_flow']); ?>;
                var callHour = <?php echo json_encode($calls['call_hour_get']); ?>;
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
                                        data: callHour,
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
                                        data: callData,
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
                                        data: ['Agent disconnect', 'Caller disconnect'

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
                                        value: "<?php echo isset($calls['total_missed_calls_data']['AgentHangup']) ? $calls['total_missed_calls_data']['AgentHangup'] : 0; ?>",
                                                name: 'Agent disconnect'
                                        },
                                        {
                                        value: "<?php echo isset($calls['total_missed_calls_data']['UserHangup']) ? $calls['total_missed_calls_data']['UserHangup'] : 0; ?>",
                                                name: 'Caller disconnect'
                                        }
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
        {{--  $('.custom-tooltip').tooltip({
        html: true, // Enable HTML content in the tooltip
                template: '<div class="tooltip" role="tooltip"><div class="tooltip-inner bg-info"><p></p></div></div>',
                });
                // Add an event listener to underline the tooltip text
                $('.custom-tooltip').on('shown.bs.tooltip', function() {
        $('.tooltip-inner').html(
                '<h5>Untouched Leads</h5><table class="table mt-0 text-white"><tr><td>Victoria</td><td>2</td></tr><tr><td>James</td><td>3</td></tr></table>'
                );
                }); --}}
        });
</script>
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total calls</h5>
                <div class="ms-auto">
                    <span class="me-1 badge bg-primary rounded-pill">{{ $calls['total_calls']}}</span>
                    <i class="ph-info ms-1" data-bs-popup="tooltip"
                       title="Details of total calls, including how many were answered and how many went unanswered"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Total connected calls </td>
                            <td>{{ $calls['total_connected_calls'] }}</td>
                        </tr>
                        <tr>
                            <td>Total unanswered incoming calls</td>
                            <td>{{ $calls['total_unanswered_calls'] }}</td>
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
                    {{--  <i class="ph-info ms-1 custom-tooltip" data-bs-popup="tooltip" title="Untouched Leads"></i>  --}}
                    <i class="ph-info ms-1 " data-bs-popup="tooltip" title="Untouched Leads" data-bs-toggle="modal"
                       data-bs-target="#UntouchedLeads"></i>
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
                    <span class="me-1 badge bg-primary rounded-pill">{{ $sales['total_converted_leads'] }}</span>
                    <i class="ph-info ms-1" data-bs-popup="tooltip"
                       title="information about converted leads from agent-based and direct sources"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Agent based leads</td>
                            <td>{{ $sales['agent_base_leads'] }}</td>
                        </tr>
                        <tr>
                            <td>Direct leads</td>
                            <td>{{ $sales['direct_leads'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Agent wise report</h5>

                <p class="cl-btn-label-title">Comparison Filter <small class="text-muted">(For the revenue, we have count average 15K per lead.)</small></p>
                <div class="btn-group c1-btn-group c1-btn-group-filter ">                       
                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_today" value="today"
                           autocomplete="off" checked="">
                    <label class="btn btn-primary me-2 border-radius-15" for="agent_filter_today">Today</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_yesterday" value="yesterday"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_yesterday">Yesterday</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_this_week" value="this_week"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_this_week">This Week</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_last_month" value="last_month"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_last_month">Last Month</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_3_months" value="3_months"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_3_months">3 Months</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_6_months" value="6_months"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_6_months">6 Months</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_this_year" value="this_year"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_this_year">This Year</label>

                    <input type="radio" class="btn-check agentselectedDate" name="agent_date" id="agent_filter_last_year" value="last_year"
                           autocomplete="off">
                    <label class="btn btn-primary mx-2 border-radius-15" for="agent_filter_last_year">Last Year</label>


                </div>
            </div>
            <div class="table-responsive">
                <table id="pending1-table" class="table datatable-basic pending1-table  table-hover table-xxs">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Agent name</th>
                            
                            <th>No of Leads</th>
                            <th>Joined Leads</th>
                            <th>Conversations</th>
                            <th>Loss</th>                  
                            
                            <th>No of Leads</th>
                            <th>Joined Leads</th>
                            <th>Conversations</th>
                            <th>Loss</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">


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
                                            <h5 class="mb-0">{{ $calls['total_inbound_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['inbound_connected_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['inbound_unanswered_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['inbound_calls_queue'] }}</h5>
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
                                            <h5 class="mb-0">{{ substr($calls['inbound_duration_hours'], 0, 8) }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['inbound_duration_minutes'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['inbound_agents'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['total_outbound_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['outbound_connected_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['outbound_unanswered_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['outbound_calls_queue'] }}</h5>
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
                                            <h5 class="mb-0">{{ substr($calls['outbound_duration_hours'], 0, 8) }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['outbound_duration_minutes'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['outbound_agents'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['total_progressive_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['progressive_connected_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['progressive_unanswered_calls'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['progressive_calls_queue'] }}</h5>
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
                                            <h5 class="mb-0">{{ substr($calls['progressive_duration_hours'], 0, 8) }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['progressive_duration_minutes'] }}</h5>
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
                                            <h5 class="mb-0">{{ $calls['progressive_agents'] }}</h5>
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
                <h5 class="mb-0">Call Hour Flow <span class="float-end badge bg-enrollment rounded-pill">{{ $calls['call_hour_flow_count'] }}
                    </span></h5>

            </div>

            <div class="card-body">
                <div class="chart-container">
                    @if ($calls['call_hour_flow_count'] > 0)
                    <div class="chart has-fixed-height" id="call_hour_flow"></div>
                    @else
                    <div class="has-fixed-height" style="text-align: center">
                        Record Not Found
                    </div>
                    @endif
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
                <table class="table datatable-basic pending-table  table-hover table-xxs">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Agent name</th>
                            <th>Leads</th>
                            <th>Converted leads</th>
                            <th>Untouched leads</th>
                            <th>Other leads</th>
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
                    {{--  <div class="d-flex justify-content-between">
                                    <span>0</span>
                                    <span>5</span>
                                    <span>10</span>
                                    <span>15</span>
                                    <span>20</span>
                                </div>  --}}
                    </th>
                    </tr>
                    </thead>
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
                            <td>{{ $calls['day_time_of_calls'] }}</td>
                        </tr>
                        <tr>
                            <td>09:00 PM - 09:00 AM<br>
                                (After office hours)
                            </td>
                            <td>{{ $calls['night_time_of_calls'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="fw-semibold mb-0">Total missed calls</h5>
                <div class="ms-auto">
                    <span class="me-1 badge bg-enrollment rounded-pill">{{ $calls['total_unanswered_calls'] }}</span>
                    <i class="ph-info ms-1 " data-bs-popup="tooltip" title="Agent Disconnect" data-bs-toggle="modal"
                       data-bs-target="#AgentDisconnect"></i>
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
<!-- modal -->
<div id="UntouchedLeads" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Untouched leads</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="table-responsive border-radius-15">
                <table class="table table-bordered table-framed">
                    <thead>
                        <tr>
                            <th>Agent name</th>
                            <th>Untouched</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales['untouched_lead_list'] as $key => $value)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="AgentDisconnect" class="modal fade" tabindex="-1">
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
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Seema yadav</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>Prerana panda</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /large modal -->
