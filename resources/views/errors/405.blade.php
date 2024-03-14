@extends('layouts.app')
@section('content')
<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">

					<!-- Container -->
					<div class="flex-fill">

						<!-- Error title -->
						<div class="text-center mb-4">
							<img src="{{ asset('assets/images/error_bg.svg') }}" class="img-fluid mb-3" height="230" alt="">
							<h1 class="display-3 fw-semibold lh-1 mb-3">405</h1>
							<h6 class="w-md-25 mx-md-auto">Oops, an error has occurred. <br> The method you are using to access the file is not allowed.</h6>
						</div>
						<!-- /error title -->


						<!-- Error content -->
						<div class="text-center">
							<a href="{{ route('ceo-revenue') }}" class="btn btn-primary">
								<i class="ph-house me-2"></i>
								Return to dashboard
							</a>
						</div>
						<!-- /error wrapper -->

					</div>
					<!-- /container -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->
@endsection
