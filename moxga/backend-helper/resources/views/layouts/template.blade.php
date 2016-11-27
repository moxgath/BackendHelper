<!doctype html>
<html class="fixed">
	@include('backendhelper::layouts.head')
	<body>
		<section class="body">

			<header class="header">
				@include('backendhelper::layouts.header')
			</header>

			<div class="inner-wrapper">
				@include('backendhelper::layouts.sidebar')

				<section role="main" class="content-body">
					@include('backendhelper::layouts.title')

					<!-- start: page -->
						@yield('content')
					<!-- end: page -->	

				</section>
			</div>

		</section>

		@include('backendhelper::layouts.javascript')
	</body>
</html>