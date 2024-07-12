			<!-- Sidebar wrapper start -->
			<nav class="sidebar-wrapper">

				<!-- Sidebar brand starts -->
				<div class="sidebar-brand">
					<a href="index.html" class="logo">
						<img src="{{ asset('admins/assets/images/logo.svg') }}" alt="Admin Dashboards" />
					</a>
				</div>
				<!-- Sidebar brand starts -->

				<!-- Sidebar menu starts -->
				<div class="sidebar-menu">
					<div class="sidebarMenuScroll">
						<ul>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-house-fill"></i>
									<span class="menu-text">Dashboard</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route(config('app_define.admin_prefix')) }}">Báo cáo</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-collection"></i>
									<span class="menu-text">Giao diện</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('banner') }}">Quản lý Banner</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-envelope-fill"></i>
									<span class="menu-text">Quản lý Email</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('mail.create') }}">Soạn Email</a>
										</li>
										<li>
											<a href="{{ route('mail',['status'=>'recive']) }}">Email nhận</a>
										</li>
										<li>
											<a href="{{ route('mail',['status'=>'send']) }}">Email gửi</a>
										</li>
										<li>
											<a href="{{ route('mail',['status'=>'all']) }}">Tất cả Email</a>
										</li>
										<li>
											<a href="{{ route('mail.recycle') }}">Thùng rác</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-handbag"></i>
									<span class="menu-text">Sản phẩm</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('category') }}"> Quản lý danh mục </a>
										</li>
										<li>
											<a href="{{ route('brand') }}">Quản lý thương hiệu</a>
										</li>
										<li>
											<a href="{{ route('product') }}">Quản lý sản phẩm</a>
										</li>
										<li>
											<a href="{{ route('coupon') }}">Quản lý mã giảm giá</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-file-text"></i>
									<span class="menu-text">Bài viết</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('type') }}"> Quản lý danh mục </a>
										</li>
										<li>
											<a href="{{ route('post') }}">Quản lý bài viết</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-person-badge"></i>
									<span class="menu-text">Người dùng</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('user') }}"> Quản lý tài khoản</a>
										</li>
										<li>
											<a href="{{ route('role') }}">Quản lý vai trò</a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-currency-exchange"></i>
									<span class="menu-text">Đơn hàng</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="{{ route('order') }}">Quản lý đơn hàng</a>
										</li>
										<li>
											<a href="{{ route('customer') }}">Thông tin khách hàng </a>
										</li>
									</ul>
								</div>
							</li>
							<li class="sidebar-dropdown">
								<a href="#">
									<i class="bi bi-credit-card-2-front-fill"></i>
									<span class="menu-text">Thanh toán online</span>
								</a>
								<div class="sidebar-submenu">
									<ul>
										<li>
											<a href="https://sandbox.vnpayment.vn/merchantv2/">Quản lý VNPay</a>
										</li>
										<li>
											<a href="https://business.momo.vn/">Quản lý Momo</a>
										</li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!-- Sidebar menu ends -->

			</nav>
			<!-- Sidebar wrapper end -->