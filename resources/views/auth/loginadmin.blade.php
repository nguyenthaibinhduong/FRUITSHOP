<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
        @include('admin.template.meta')
        @include('admin.template.css')


	</head>

	<body class="login-container bg-primary">

		<!-- Loading wrapper start -->
		<div id="loading-wrapper">
			<div class="spinner">
                <div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
            </div>
		</div>
		<!-- Loading wrapper end -->

		<!-- Login box start -->
		<form action="" method="post">
            @csrf
			<div class="login-box">
				<div class="login-form">
					<h3 class="text-center text-primary">Đăng nhập Admin</h3>
					<div class="mb-3">
						<label class="form-label">Email</label>
						<input name='email' type="text" class="form-control" placeholder="Nhập email" autocomplete="off">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>
					<div class="mb-3">
						<div class="d-flex justify-content-between">
							<label class="form-label">Mật khẩu</label>
							<a href="forgot-password.html" class="btn-link ml-auto">Quên mật khẩu ?</a>
						</div>
						<input name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" autocomplete="off">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>
					<div class="login-form-actions">
						<button type="submit" class="btn"> <span class="icon"> <i class="bi bi-arrow-right-circle"></i> </span>
							Đăng nhập</button>
					</div>
					{{-- <div class="login-form-actions">
						<button type="submit" class="btn"> <img src="assets/images/google.svg" class="login-icon"
								alt="Login with Google">
							Login with Google</button>
						<button type="submit" class="btn"> <img src="assets/images/facebook.svg" class="login-icon"
								alt="Login with Facebook">
							Login with Facebook</button>
					</div> --}}
					{{-- <div class="login-form-footer">
						<div class="additional-link">
							Nếu bạn chưa có tài khoản ? <a href="{{ route('register') }}">Đăng ký</a>
						</div>
					</div> --}}
				</div>
			</div>
		</form>
        @include('admin.template.script');
	</body>

</html>