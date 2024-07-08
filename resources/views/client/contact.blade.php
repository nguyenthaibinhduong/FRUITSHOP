@extends('client.layout.master_layout')
@section('content')
   <!-- Breadcrumb Section Begin -->
   <section class="breadcrumb-section set-bg" data-setbg="{{ asset('client/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Organi Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<section>
    @if (session('success'))
        <div class="row">
            <div class="col-10 mx-auto p-3 border my-4">
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <form class="col-10 mx-auto p-3 border my-4" method="post" action="{{ route('contact.post') }}">
        <h3 class='py-2 font-weight-bold'>CONTACT BY MAIL</h3> 
        <div class="mb-3">
            <label>Your Name</label> <input class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label>Email</label> <input class="form-control" name="email" type="email" required>
        </div>
        <div class="mb-3">
            <label>Content</label> <textarea rows="10" class="form-control" name="content"></textarea>
        </div>
        <div class="mb-3"> @csrf
            <button type="submit" class="btn btn-warning p-2">Send Email</button>
        </div>
        </form> 
</section>
   
@endsection