	<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{ asset('admins/assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('admins/assets/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('admins/assets/js/modernizr.js') }}"></script>
		<script src="{{ asset('admins/assets/js/moment.js') }}"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Data Tables -->
		<script src="assets/vendor/datatables/dataTables.min.js"></script>
		<script src="assets/vendor/datatables/dataTables.bootstrap.min.js"></script>

		<!-- Custom Data tables -->
		<script src="assets/vendor/datatables/custom/custom-datatables.js"></script>

		<script src="{{ asset('admins/assets/vendor/particles/particles.min.js') }}"></script>
		<script src="{{ asset('admins/assets/vendor/particles/particles-custom.js') }}"></script>
		<!-- Overlay Scroll JS -->
		<script src="{{ asset('admins/assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
		<script src="{{ asset('admins/assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

		<!-- Apex Charts -->
		<script src="{{ asset('admins/assets/vendor/apex/apexcharts.min.js') }}"></script>
		<script src="{{ asset('admins/assets/vendor/apex/custom/sales/salesGraph.js') }}"></script>
		<script src="{{ asset('admins/assets/vendor/apex/custom/sales/revenueGraph.js') }}"></script>
		<script src="{{ asset('admins/assets/vendor/apex/custom/sales/taskGraph.js') }}"></script>

		<!-- Main Js Required -->
		<script src="{{ asset('admins/assets/js/main.js') }}"></script>

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/modernizr.js"></script>
		<script src="assets/js/moment.js"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->



		

		

		<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
		<script>
		var options = {
			filebrowserImageBrowseUrl: '/filemanager?type=Images',
			filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
			filebrowserBrowseUrl: '/filemanager?type=Files',
			filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
		};
		</script>
		<script>
			CKEDITOR.replace('my-editor', options);
		</script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
		<script>
		$('textarea.my-editor').ckeditor(options);
		</script>

		