@extends('Admin.layouts.app')
@push('head_script')
    <script>
        $(document).ready(function() {
            ceoRevenue('today', 'revenue');

            $('.selectedDate, .selectedCourse').click(function() {
                var selectedDate = $('input[name="date"]:checked').val();
                var selectedCourse = $('input[name="course"]:checked').val();
                if (selectedDate != 'custom') {
                    ceoRevenue(selectedDate, selectedCourse);
                } else {
                    var startDate = $('#startDate').val();
                    var endDate = $('#endDate').val();
                    // console.log(startDate);
                    // console.log(endDate);
                    if (startDate.length > 0 && endDate.length > 0) {

                        ceoRevenue(selectedDate, selectedCourse, startDate, endDate);
                    }
                }
            });

            function ceoRevenue(dateData, courseData, startDate = null, endDate = null) {
                $('.dashboardContent').html('');
                $("#loader").removeClass('d-none');
                $.ajax({
                    url: "{{ route('ceo-revenue') }}",
                    type: 'GET',
                    data: {
                        date: dateData,
                        course: courseData,
                        start_date: startDate,
                        end_date: endDate,
                    },
                    success: function(response) {
                        $("#loader").addClass('d-none');
                        $('.dashboardContent').html(response);
                    }
                });
            }

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
                        'left', // double check this !!!!!!!!!!!!!!!!!!!!!!
                        parentEl: '.content-inner',
                    },
                    function(start, end) {
                        var selectedDate = $('input[name="date"]:checked').val();
                        var selectedCourse = $('input[name="course"]:checked').val();
                        var startDate = start.format('YYYY-MM-DD');
                        var endDate = end.format('YYYY-MM-DD');
                        $('#startDate').val(startDate);
                        $('#endDate').val(endDate);
                        ceoRevenue(selectedDate, selectedCourse, startDate, endDate);
                    }
                );
            }
            _componentDaterange();
        });
    </script>
@endpush
@section('content')
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content d-lg-flex">
            <div class="d-flex">
                <h4 class="page-title mb-0">
                    Welcome to CEO Revenue Dashboard <span class="fw-normal"><img
                            src="{{ asset('assets/images/icons/hand.png') }}" alt="hand" class="ms-2"></span>
                    <span class="fw-normal text-muted ms-2 fs-base fw-medium dashboardShowDate">({{ now()->format('Y-m-d') }}
                        to {{ now()->format('Y-m-d') }})</span>
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

                <input type="radio" class="btn-check selectedDate" name="date" id="custom" value="custom"
                    autocomplete="off">
                <label class="btn btn-primary mx-2 border-radius-15 daterange-ranges" for="custom">Custom</label>
                <input type="hidden" id="startDate">
                <input type="hidden" id="endDate">
            </div>
        </div>
        <div class="row mb-4">
            <div class="btn-group c-btn-group">
                <input type="radio" class="btn-check selectedCourse" name="course" id="revenue" value="revenue"
                    autocomplete="off" checked="">
                <label class="btn btn-success text-success me-2 border-radius-15" for="revenue">Revenue</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="sales" value="sales"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="sales">Sales</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="cat" value="cat"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="cat">CAT</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="non_cat" value="non_cat"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="non_cat">Non-CAT</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="study_abroad"
                    value="study_abroad" autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="study_abroad">Study Abroad</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="undergrad" value="undergrad"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="undergrad">UnderGrad</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="gdpi" value="gdpi"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="gdpi">GDPI</label>

                <input type="radio" class="btn-check selectedCourse" name="course" id="mocks" value="mocks"
                    autocomplete="off">
                <label class="btn btn-success text-success mx-2 border-radius-15" for="mocks">Mocks</label>

            </div>
        </div>

        <div class="dashboardContent mt-3"></div>
        <div id="loader" class="d-flex justify-content-around mt-5 fs-1">
            <div class="spinner-border my-auto" role="status">
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
