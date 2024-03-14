@extends('Admin.layouts.app')
@section('content')
    <div class="content d-flex justify-content-center align-items-center">
        <div class="flex-fill">
            <div class="text-center">
                <img src="{{ asset('assets/images/comingSoon.png') }}" class="img-fluid mb-3" height="400" width="500"
                    alt="">
                {{--  <h1 class=" fw-semibold lh-1 mb-3">Coming Soon...</h1>  --}}
                <h1 class="display-3 fw-semibold lh-1 mb-3">Coming Soon...</h1>
                <h6 class="w-md-25 mx-md-auto">Oops, an error has occurred. <br> The resource requested could not be found
                    on this server.</h6>
            </div>
            <div class="text-center">
                <a href="{{ route('ceo-revenue') }}" class="btn btn-primary">
                    <i class="ph-house me-2"></i>
                    Return to CEO Revenue
                </a>
            </div>
        </div>
    </div>
@endsection
