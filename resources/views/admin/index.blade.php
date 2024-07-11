@extends('admin.layout.master')
@section('content')
						<div class="content-wrapper">

						<!-- Row start -->
						<div class="row">
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="stats-tile">
									<div class="sale-icon shade-red">
										<i class="bi bi-pie-chart"></i>
									</div>
									<div class="sale-details">
										<h3 class="text-red">{{ number_format($sales, 0, ',', '.').'đ' }} / đơn</h3>
										<p>Trung bình trên đơn</p>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="stats-tile">
									<div class="sale-icon shade-blue">
										<i class="bi bi-emoji-smile"></i>
									</div>
									<div class="sale-details">
										<h3 class="text-blue">{{ $num_customers }}</h3>
										<p>Tổng số khách hàng đã mua hàng</p>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="stats-tile">
									<div class="sale-icon shade-yellow">
										<i class="bi bi-box-seam"></i>
									</div>
									<div class="sale-details">
										<h3 class="text-yellow">{{ $num_products }}</h3>
										<p>Số mặt hàng sản phẩm</p>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-sm-6 col-12">
								<div class="stats-tile">
									<div class="sale-icon shade-green">
										<i class="bi bi-handbag"></i>
									</div>
									<div class="sale-details">
										<h3 class="text-green">{{ number_format($revenue, 0, ',', '.').'đ' }}</h3>
										<p>Doanh thu</p>
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<!-- Row start -->
						<div class="row">
							<div class="col-xxl-9  col-sm-12 col-12">

								<div class="card">
									<div class="card-body">

										<!-- Row start -->
										<div class="row">
											<div class="col-xxl-3 col-sm-4 col-12">
												<div class="reports-summary">
													<div class="reports-summary-block">
														<i class="bi bi-circle-fill text-primary me-2"></i>
														<div class="d-flex flex-column">
															<h6>Overall Sales</h6>
															<h5>12 Millions</h5>
														</div>
													</div>
													<div class="reports-summary-block">
														<i class="bi bi-circle-fill text-success me-2"></i>
														<div class="d-flex flex-column">
															<h6>Overall Earnings</h6>
															<h5>78 Millions</h5>
														</div>
													</div>
													<div class="reports-summary-block">
														<i class="bi bi-circle-fill text-danger me-2"></i>
														<div class="d-flex flex-column">
															<h6>Overall Revenue</h6>
															<h5>60 Millions</h5>
														</div>
													</div>
													<div class="reports-summary-block">
														<i class="bi bi-circle-fill text-warning me-2"></i>
														<div class="d-flex flex-column">
															<h6>New Customers</h6>
															<h5>23k</h5>
														</div>
													</div>
													<button class="btn btn-info download-reports">View Reports</button>
												</div>
											</div>
											<div class="col-xxl-9 col-sm-8 col-12">
												<div class="row">
													<div class="col-12">
														<div class="graph-day-selection mt-2" role="group">
															<button type="button" class="btn active">Today</button>
															<button type="button" class="btn">Yesterday</button>
															<button type="button" class="btn">7 days</button>
															<button type="button" class="btn">15 days</button>
															<button type="button" class="btn">30 days</button>
														</div>
													</div>
													<div class="col-12">
														<div id="revenueGraph"></div>
													</div>
												</div>
											</div>
										</div>
										<!-- Row end -->

									</div>
								</div>

							</div>
							<div class="col-xxl-3  col-sm-12 col-12">

								<div class="card">
									<div class="card-header">
										<div class="card-title">Sales</div>
									</div>
									<div class="card-body">
										<div id="salesGraph" class="auto-align-graph"></div>
										<div class="num-stats">
											<h2>2100</h2>
											<h6 class="text-truncate">12% higher than last month.</h6>
										</div>
									</div>
								</div>

							</div>
						</div>
						<!-- Row end -->

					</div>
@endsection