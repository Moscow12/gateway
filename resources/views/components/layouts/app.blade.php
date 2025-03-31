<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ asset('admin/img/favicon.png') }}" type="image/x-icon">
	<!--plugins-->
	<link href="{{ asset('admin/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('admin/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('admin/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('admin/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('admin/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/css/header-colors.css') }}" />
	<title>CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
        
		<!--sidebar wrapper -->
		<livewire:navigation.sidebar/>
		<!--end sidebar wrapper -->

		<!--start header -->
        <livewire:navigation.header/>
		<!-- @include('livewire.navigation.header') -->
		<!--end header -->

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Error</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Blank Page</li>
							</ol>
						</nav>
					</div>
				</div> -->
				<!--end breadcrumb-->
                <section class="content">
                    <div class="container-fluid">
                        {{ $slot }}
                    </div>
                </section>
			</div>
		</div>
		<!--end page wrapper -->

		<!-- footer -->
         <livewire:navigation.footer />
		<!-- @include('livewire.navigation.footer') -->
		<!-- end footer -->
	</div>

	<!--start switcher-->    
	<!-- @include('livewire.navigation.topnavigation') -->
	<!--end switcher-->

	<!-- Bootstrap JS -->
	<script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('admin/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<!--app JS-->
	<script src="{{ asset('admin/js/app.js') }}"></script>
</body>

</html>