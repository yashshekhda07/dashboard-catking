@extends('Admin.layouts.app')
@push('head_script')
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script>
        var activeAjaxRequests = [];

        $(document).ready(function() {
            const _componentDaterange = function() {
                $('.daterange-ranges').daterangepicker({
                        startDate: moment().subtract(29, 'days'),
                        endDate: moment(),
                        // minDate: '01/01/2020',
                        // maxDate: '12/31/2021',
                        // dateLimit: {
                        //     days: 360
                        // },
                        opens: document.dir == 'rtl' ? 'right' :
                        'left',
                        parentEl: '.content-inner',
                    },
                    function(start, end) {
                        var selectedDate = $('input[name="date"]:checked').val();
                        var selectedCourse = $('input[name="course"]:checked').val();
                        var startDate = start.format('YYYY-MM-DD');
                        var endDate = end.format('YYYY-MM-DD');
                        $('#startDate').val(startDate);
                        $('#endDate').val(endDate);
                        analyticData();
                    }
                );
            }
            _componentDaterange();

            analyticData();

            $('.selectedDate').change(function() {
                analyticData();
            })
        })

        function analyticData() {
            const loader = `<div class="data_loader" style="text-align:center; margin-top:80px;">
                <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"
                    stroke="#027AFB">
                    <g fill="none" fill-rule="evenodd" stroke-width="2">
                        <circle cx="22" cy="22" r="1">
                            <animate attributeName="r" begin="0s" dur="1.8s" values="1; 20" calcMode="spline"
                                keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" />
                            <animate attributeName="stroke-opacity" begin="0s" dur="1.8s" values="1; 0"
                                calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1"
                                repeatCount="indefinite" />
                        </circle>
                        <circle cx="22" cy="22" r="1">
                            <animate attributeName="r" begin="-0.9s" dur="1.8s" values="1; 20" calcMode="spline"
                                keyTimes="0; 1" keySplines="0.165, 0.84, 0.44, 1" repeatCount="indefinite" />
                            <animate attributeName="stroke-opacity" begin="-0.9s" dur="1.8s" values="1; 0"
                                calcMode="spline" keyTimes="0; 1" keySplines="0.3, 0.61, 0.355, 1"
                                repeatCount="indefinite" />
                        </circle>
                    </g>
                </svg>
            </div>`;
            $('.dashboardContent').html(loader);
            var analyticTerm = $('input[name="analytic_term"]:checked').val();
            $.ajax({
                url: '{{ route('support.analyticData') }}',
                type: 'get',
                data: {
                    analyticTerm
                },
                beforeSend: function() {
                    activeAjaxRequests.forEach(function(request, index) {
                        request.abort();
                        activeAjaxRequests.splice(index, 1);
                    });
                },
                success: function(res) {
                    $('.dashboardContent').html(res);
                }
            })
        }

        function convertTime(timeString) {
            let [hours, minutes, seconds] = timeString.split(':').map(Number);
            let totalHours = hours + Math.floor(minutes / 60);
            let remainingMinutes = minutes % 60;
            return `${totalHours}H ${remainingMinutes}MIN ${seconds}SEC`;
        }
    </script>
@endpush
@section('content')
    <style>
        p {
            margin: 0;
        }

        .card_box_shadow {
            /*box-shadow: 0px 3px 7px rgba(0, 0, 0, 0.3);*/
            /*border-radius: 30px;*/
        }

        .progress {
            height: 14px;
        }

        .progress-bar {
            border-radius: 10px;
        }

        .progress-bar-striped {
            background: #6186FF;
            position: relative;
        }

        .progress_pointer {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            margin-right: 2px;
            padding: 5px;
            position: absolute;
            top: 50%;
            right: 0;
            transform: translate(-10%, -50%);
        }

        .text-count-background {
            background-color: #C8E4FF33 !important;
            font-size: 18px;
            font-weight: bold;
        }

        .w-80 {
            width: 80% !important;
        }

        .card_table_container .data_loader {
            display: none;
            background: white;
            width: 100%;
            height: calc(100% - 65px);
            position: absolute;
            border-radius: 5px;
            z-index: 200;
            top: 65px;
        }

        .card_table_container .data_loader svg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content d-lg-flex">
            <div class="d-flex">
                <h4 class="page-title mb-0">
                    Welcome to Support Dashboard <span class="fw-normal"><img
                            src="{{ asset('assets/images/icons/hand.png') }}" alt="hand" class="ms-2"></span>
                    <span
                        class="fw-normal text-muted ms-2 fs-base fw-medium dashboardShowDate">({{ now()->format('F jS, Y') }}
                        to {{ now()->format('F jS, Y') }})</span>
                </h4>

                <a href="#page_header"
                    class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto"
                    data-bs-toggle="collapse">
                    <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /page header -->


    <!-- Content area -->
    <div class="content pt-0">
        <div class="row mb-4">
            <div class="btn-group c1-btn-group">
                <input type="radio" class="btn-check selectedDate" name="date" id="today" value="today"
                    autocomplete="off" checked="">
                <label class="btn btn-primary me-2 border-radius-15" for="today">Today</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="yesterday" value="yesterday"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="yesterday">Yesterday</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="this_week" value="this_week"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="this_week">This Week</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="last_month" value="last_month"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="last_month">Last Month</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="3_months" value="3_months"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="3_months">3 Months</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="6_months" value="6_months"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="6_months">6 Months</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="this_year" value="this_year"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="this_year">This Year</label>

                <input type="radio" class="btn-check selectedDate" name="date" id="last_year" value="last_year"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15" for="last_year">Last Year</label>

                <input type="radio" class="btn-check" name="date" id="custom" value="custom" autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15 daterange-ranges" for="custom">Custom</label>
                <input type="hidden" id="startDate">
                <input type="hidden" id="endDate">
            </div>
        </div>
        <div class="row mb-4 col-md-10 col-sm-12">
            <div class="btn-group c-btn-group">
                <input type="radio" class="btn-check selectedCourse" name="analytic_term" id="revenue" value="overview"
                    autocomplete="off" checked="" onchange="analyticData()">
                <label class="btn btn-success text-success me-2 border-radius-15" for="revenue">Overview</label>

                <input type="radio" class="btn-check selectedCourse" name="analytic_term" id="sales"
                    value="agent_analysis" autocomplete="off" onchange="analyticData()">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="sales">Agent Analysis</label>

                <input type="radio" class="btn-check selectedCourse" name="analytic_term" id="cat"
                    value="courses_analysis" autocomplete="off" onchange="analyticData()">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="cat">Course Analysis</label>

                <input type="radio" class="btn-check selectedCourse" name="analytic_term" id="non_cat"
                    value="non_cat" autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="non_cat">Student Analysis</label>
            </div>
        </div>

        <div class="dashboardContent mt-3">

        </div>
        {{-- <div id="loader" class="d-flex justify-content-around mt-5 fs-1">
            <div class="spinner-border my-auto" role="status">
            </div>
        </div> --}}
    </div>

    <script></script>
@endsection
