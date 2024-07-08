@php
   $object='customer';
   $object_title='khách hàng';
@endphp
@extends('admin.layout.master')
@section('breadcrumb')
<ol class="breadcrumb d-md-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route($object) }}">{{ ucfirst($object_title) }}</a>
    </li>
    <li class="breadcrumb-item breadcrumb-active" aria-current="page">Chi tiết {{ $object_title }}</li>
</ol>
@endsection
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary text-center"></h3>
    </div>
    <div class="card-body">
        
        <div class="d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin cá nhân</h6>
            <a class="text-warning" href="{{ route($object.'.edit',['id'=>$user->id]) }}">Chỉnh sửa thông tin <i class="bi bi-pencil-square fs-5 me-3 "></i></a>
        </div>
       
        <div class="row table-responsive">
            <div class="col-3">
                <div class="d-flex justify-content-center mt-2"><img width="200px" height="200px" src="{{ ($user->image_url)?asset($user->image_url):asset('img/logo/user-1.jpg') }}" alt=""></div>
                
            </div>
            <div class="col-9">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <tr>
                        <td>Tên khách hàng </td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Ngày sinh</td>
                        <td>
                            @if($user->birth_date!=null)
                                {{ Carbon::parse($user->birth_date)->format('d/m/Y') }}
                            @else
                                <a  class="text-primary" href=""><i>chưa cập nhật thông tin</i></a>
                            @endif
                        </td>
                    </tr>  
                    <tr>
                        <td>Giới tính</td>
                        <td>
                            @if($user->gender==1)
                            Nam
                            @elseif($user->gender==2)
                            Nữ
                            @else
                            <a  class="text-primary" href=""><i>chưa cập nhật thông tin</i></a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Số điện thoại</td>
                        <td>
                            @if($user->phone_number!=null)
                                {{  $user->phone_number }}
                            @else
                                <a  class="text-primary" href=""><i>chưa cập nhật thông tin</i></a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td>
                            @if($user->address!=null)
                                {{  $user->address }}
                            @else
                                <a  class="text-primary" href=""><i>chưa cập nhật thông tin</i></a>
                            @endif</td>
                    </tr>
                </tbody>
            </table>
            </div>
            
        </div>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Đơn hàng đã đặt</h6><br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th scope="col">Thứ tự</th>
                      <th scope="col">Mã đơn hàng</th>
                      <th scope="col">Giá trị</th>
                      <th scope="col">Trạng thái</th>
                      <th scope="col">Ngày đặt</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($orders as $order)
                      <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $order->order_code }}</td>
                          <td>${{ $order->total_price }}</td>
                          <td><i class="font-weight-bold">{{ $order->statuses->name }}</i></td>
                          <td>{{ $order->created_at->format('d/m/Y')}}</td>
                          <td>
                              <a class="text-primary" href="{{ route('order.detail',['id'=>$order->id]) }}">Xem chi tiết >></a>
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6><br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <tbody>
                    <tr>
                        <td><p class="text-dark" style="font-weight: 800">Tổng chi tiêu</p></td>
                        <td><p class="text-dark" style="font-weight: 800">${{ $total }}</p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection