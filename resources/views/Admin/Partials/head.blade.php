<meta charset="utf-8">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Laravel') }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/catking-logo.png') }}">

<!-- Global stylesheets -->
<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/ltr/all.min.css') }}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<!-- Core JS files -->
<script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- /Core JS files -->


<!-- Jquery JS files -->
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<!-- Jquery JS files -->

<script src="{{ asset('assets/js/vendor/visualization/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/visualization/d3/d3v5.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/visualization/c3/c3.min.js') }}"></script>

<script src="{{ asset('assets/js/vendor/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/vendor/pickers/datepicker.min.js') }}"></script>

<!-- Theme JS files -->
<script src="{{ asset('assets/js/app.js') }}"></script>
{{--  <script src="{{ asset('assets/demo/pages/components_tooltips.js') }}"></script>  --}}

{{--  <script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>  --}}
<!-- /theme JS files -->

<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
