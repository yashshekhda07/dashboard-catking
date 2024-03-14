<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('Admin.Partials.head')
    @stack('head_script')
</head>

<body>
    <!-- Page content -->
    <div class="page-content">
        @include('Admin.Partials.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Main navbar -->
            @include('Admin.Partials.navbar')
            <!-- /main navbar -->

            <div class="content-inner mb-4">
                <!-- Content area -->
                @yield('content')
                <!-- /content area -->

                <div id="myModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false"
                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

                <script>
                    $(document).on('click', '.ajaxviewmodel', function(event) {
                        var tmp_html =
                            '<div class="modal-dialog"><div class="modal-content"><div class="modal-body"><p class="ajaxloader text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw margin-bottom margin-top text-center"></i></p></div></div></div>';
                        event.preventDefault();
                        var selectedDate = $('input[name="date"]:checked').val();
                        var selectedCourse = $('input[name="course"]:checked').val();
                        var startDate = $('#startDate').val();
                        var endDate = $('#endDate').val();

                        var link = $(this).attr("href");
                        $("#myModal").html(tmp_html);
                        $('#myModal').modal('show');
                        $.ajax({
                            url: link,
                            type: 'GET',
                            data: {
                                date: selectedDate,
                                course: selectedCourse,
                                start_date: startDate,
                                end_date: endDate,
                            },
                            success: function(data) {
                                {{--  $(".ajaxloader").hide();  --}}
                                $("#myModal").html(data);
                            }
                        });
                    });
                </script>
            </div>
            @include('Admin.Partials.footer')
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</body>

</html>
