<!-- *************
			************ Common Css Files *************
		************ -->

		<!-- Animated css -->
		<link rel="stylesheet" href="{{ asset('admins/assets/css/animate.css') }}">

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="{{ asset('admins/assets/fonts/bootstrap/bootstrap-icons.css') }}">

		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('admins/assets/css/main.min.css') }}">


		<!-- *************
			************ Vendor Css Files *************
		************ -->
			<style>

				@media only screen and (max-width: 600px) {
					.login-box{
						padding-top: 30%;
						padding-left:10%;
						padding-right:10%;
						width: 100vw;
						height: 100vh;
					}
					.register-box{
						padding-top: 10%;
					}
				}

				/* Tablets (medium screens, 600px to 1024px) */
				@media only screen and (min-width: 601px) and (max-width: 1024px) {
					.login-box{
						width: 70vh;
					}
				}

				/* Desktops (large screens, 1024px and up) */
				@media only screen and (min-width: 1025px) {
					
				}
				input:-webkit-autofill,
				input:-webkit-autofill:hover,
				input:-webkit-autofill:focus,
				textarea:-webkit-autofill,
				textarea:-webkit-autofill:hover,
				textarea:-webkit-autofill:focus,
				select:-webkit-autofill,
				select:-webkit-autofill:hover,
				select:-webkit-autofill:focus {
				border: 1px solid #ccc;
				-webkit-text-fill-color: #232629;
				box-shadow: 0 0 0px 100px rgba(226, 215, 215, 0.8) inset;
}
			</style>
		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="{{ asset('admins/assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}">
		