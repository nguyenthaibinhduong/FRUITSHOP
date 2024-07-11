 <!-- Css Styles -->
 <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/font-awesome.min.css') }}" type="text/css">
 <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('client/css/elegant-icons.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/nice-select.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/jquery-ui.min.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/owl.carousel.min.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/slicknav.min.css') }}" type="text/css">
 <link rel="stylesheet" href="{{ asset('client/css/style.css') }}" type="text/css">

 <style>
    /* Mobile devices (small screens, 600px and down) */
    @media only screen and (max-width: 600px) {
        .resultSearch{
            top:50px;
            left: 15px;
            right: 15px;
        }
        .owl-nav{
            display: none;
        }
         .offcanvas {
        position: fixed;
        top: 0;
        bottom: 0;
        right: -400px; /* Bắt đầu ở bên phải ngoài màn hình */
        width: 80vw;
        padding: 1rem;
        background-color: #fff; /* Đặt nền màu trắng */
        transition: right 0.3s ease;
        z-index: 1050;
        }
    }

    /* Tablets (medium screens, 600px to 1024px) */
    @media only screen and (min-width: 601px) and (max-width: 1024px) {
        .resultSearch{
            top:50px;
            left: 15px;
            right: calc(45% + 6px);
        }
        .owl-nav{
            display: none;
        }
         .offcanvas {
        position: fixed;
        top: 0;
        bottom: 0;
        right: -400px; /* Bắt đầu ở bên phải ngoài màn hình */
        width: 400px;
        padding: 1rem;
        background-color: #fff; /* Đặt nền màu trắng */
        transition: right 0.3s ease;
        z-index: 1050;
        }
    }

    /* Desktops (large screens, 1024px and up) */
    @media only screen and (min-width: 1025px) {
        .resultSearch{
            top:48px;
            left: 15px;
            right: calc(40% + 11px);
        }
        .offcanvas {
        position: fixed;
        top: 0;
        bottom: 0;
        right: -400px; /* Bắt đầu ở bên phải ngoài màn hình */
        width: 400px;
        padding: 1rem;
        background-color: #fff; /* Đặt nền màu trắng */
        transition: right 0.3s ease;
        z-index: 1050;
        }
    }
    .pagination{
       
    }
    .pagination .page-link {
    color: #7fad39; /* Màu chữ mặc định */
    background-color: #fff; /* Màu nền mặc định */
    border-color: #fff; /* Màu viền mặc định */
    }

    .pagination .page-link:hover {
        color: #fff; /* Màu chữ khi hover */
        background-color: #7fad39; /* Màu nền khi hover */
        border-color: #7fad39; /* Màu viền khi hover */
    }

    .pagination .page-item.active .page-link {
        color: #fff; /* Màu chữ khi active */
        background-color: #7fad39; /* Màu nền khi active */
        border-color: #7fad39; /* Màu viền khi active */
    }
    .ajaxSearch{
        position: relative;
    }
    .resultSearch{
        z-index: 2;
        position: absolute;

    }

    
    .offcanvas.show {
      right: 0; /* Hiển thị offcanvas bằng cách di chuyển vào màn hình */
    }
    .offcanvas-backdrop {
      position: fixed;
      top: 0;sc
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
      z-index: 1040;
      display: none;
    }
    .offcanvas-backdrop.show {
      display: block;
    }
    .comment-box {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .comment-avatar {
            margin-right: 15px;
        }
        .comment-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .comment-content {
            flex-grow: 1;
        }
        .comment-content p {
            max-width:500px;
            margin: 0;
        }
        .comment-content small {
            display: block;
            color: #888;
        }
        .comment-form {
            display: flex;
            align-items: flex-start;
            margin-top: 15px;
        }
        .comment-form textarea {
            flex-grow: 1;
            margin-right: 10px;
        }

</style>