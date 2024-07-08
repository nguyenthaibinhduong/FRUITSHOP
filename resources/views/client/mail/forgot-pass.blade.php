Chào {{$name}}! Chúng tôi liên hệ để hỗ trợ cung cấp lại mật khẩu 
<hr>
<p>Họ tên khách hàng: {{$name}}</p>
<p>Email: {{$email}}</p>
<p>
    Hãy truy cập đường <a href="{{ route('reset-password',['token'=>$token]) }}">LINK</a> sau để có thể xác thực và tạo mật khẩu mới.
</p>
<p>
    Cảm ơn !
</p>