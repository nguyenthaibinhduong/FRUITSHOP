@php
    use Carbon\Carbon;
@endphp
<div style="font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;">
  <div style="width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <div style="text-align: center;
      padding-bottom: 20px;" class="header">
      <h4 style="color: #333;text-align: center;">Thông Tin Đơn Hàng #{{ $order->order_code }}</h4>
    </div>
    <h2>Thông Tin Mua Hàng </h2>
    <table style="width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;">
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Tên khách hàng</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $order->customer_name }}</td>
      </tr>
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Địa chỉ</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $order->customer_address }}</td>
      </tr>
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Email</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $order->customer_email }}</td>
      </tr>
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Số điện thoại</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $order->customer_tel}}</td>
      </tr>
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Thời gian đặt hàng</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <th style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left;background-color: #f0f0f0;">Phương thức thanh toán</th>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ ($order->payment_method==1)?'Tiền mặt':'Chuyển khoản'}}</td>
      </tr>
    </table>

    <h4 style="text-align: center">Thông Tin Sản Phẩm Mua Hàng</h4>
    <table style="width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;">
      <tr>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Tên sản phẩm</th>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Số lượng</th>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Giá</th>
      </tr>
      @foreach($order_detail as $orders)
      <tr>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $orders->product->name }}</td>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ $orders->quantity }}</td>
        <td  style="padding: 10px;
      border: 1px solid #ddd;
      text-align: left">{{ number_format($orders->price, 0, ',', '.').'đ' }}</td>
      </tr>
      @endforeach
      <tr>
        <th  colspan="2" style="text-align: right;padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Tổng cộng</th>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">{{ number_format($order->total, 0, ',', '.').'đ' }}</th>
      </tr>
      <tr>
        <th colspan="2" style="text-align: right;padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Chiết khấu</th>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">-{{ number_format($order->discount, 0, ',', '.').'đ' }}</th>
      </tr>
      <tr>
        <th colspan="2" style="text-align: right;padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">Thành tiền</th>
        <th  style="padding: 10px;
        border: 1px solid #ddd;
        text-align: left;background-color: #f0f0f0;">{{ number_format($order->total_price, 0, ',', '.').'đ' }}</th>
      </tr>
    </table>
  </div>
</div>
