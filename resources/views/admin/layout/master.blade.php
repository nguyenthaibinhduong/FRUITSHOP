<!doctype html>
<html lang="en">

	<head>
        @include('admin.template.meta')
        @include('admin.template.css')
	</head>

	<body>
		@include('admin.template.loading')
		<div class="page-wrapper">
			@include('admin.template.sidebar')
			<div class="main-container">
				@include('admin.template.header')
				<div class="content-wrapper-scroll">
					<div class="content-wrapper">
						@yield('content')
					</div>
					@include('admin.template.footer')

				</div>
			</div>
		</div>
		@include('admin.template.script');
	</body>
</html>