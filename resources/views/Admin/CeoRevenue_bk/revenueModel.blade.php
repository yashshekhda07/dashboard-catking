<script type="text/javascript" src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>
<script>
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
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                {{--  delete_recodes();  --}}
            },
            preDrawCallback: function() {
                $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass(
                    'dropup');
            }
        });
        $('.pending-table').DataTable({
            "processing": true,
            "serverSide": true,
            "select": true,
            "ajax": {
                "url": "{{ route('ceo-revenue-getData') }}",
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
                    "data": "order_id",
                },
                {
                    "data": "name",
                },
                {
                    "data": "email"
                },
                {
                    "data": "phone_number"
                },
                {
                    "data": "course_name"
                },
            ]
        });
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            width: 'auto'
        });

        function delete_recodes() {

            var i = 0;
            if (Array.prototype.forEach) {

                var elems = $('.switchery');
                $.each(elems, function(key, value) {
                    var $size = "",
                        $color = "",
                        $sizeClass = "",
                        $colorCode = "";
                    $size = $(this).data('size');
                    var $sizes = {
                        'lg': "large",
                        'sm': "small",
                        'xs': "xsmall"
                    };
                    if ($(this).data('size') !== undefined) {
                        $sizeClass = "switchery switchery-" + $sizes[$size];
                    } else {
                        $sizeClass = "switchery";
                    }

                    $color = $(this).data('color');
                    var $colors = {
                        'primary': "#967ADC",
                        'success': "#37BC9B",
                        'danger': "#DA4453",
                        'warning': "#F6BB42",
                        'info': "#3BAFDA"
                    };
                    if ($color !== undefined) {
                        $colorCode = $colors[$color];
                    } else {
                        $colorCode = "#37BC9B";
                    }

                    var switchery = new Switchery($(this)[0], {
                        className: $sizeClass,
                        color: $colorCode
                    });
                });
            } else {
                var elems1 = document.querySelectorAll('.switchery');
                for (i = 0; i < elems1.length; i++) {
                    var $size = elems1[i].data('size');
                    var $color = elems1[i].data('color');
                    var switchery = new Switchery(elems1[i], {
                        color: '#37BC9B'
                    });
                }
            }


            $(".switch").change(function() {
                var id = $(this).attr("data-value");

                var state = 0;
                if ($(this).prop("checked") == true) {
                    state = 1;
                } else if ($(this).prop("checked") == false) {
                    state = 0;
                }
                var url = "{{ URL::to('admin/city/activedeactive') }}";
                url = url + "/" + id + "/" + state;
                $.ajax({
                    url: url
                }).done(function(data) {
                    if (data == 1) {
                        if (state == 1) {
                            toastr.success('City  has been Activated', 'Activated');
                        } else {
                            toastr.error('City has been Deactivated', 'Deactivated');
                        }
                    } else {
                        toastr.error('Something went wrong..', 'Error');
                    }

                });
            });
        }


    });
</script>

<!-- Basic modal -->
<div class="modal-dialog modal-xl  border-radius-15">
    <div class="modal-content border-radius-15">
        <div class="modal-header">
            <h5 class="modal-title">Students List For Failed Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="table-responsive border-radius-15">
            <table class="table datatable-basic pending-table table-bordered table-framed">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Order Id</th>
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Phone Number</th>
                        <th>Course Name</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- /basic modal -->
