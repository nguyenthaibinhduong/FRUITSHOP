<!DOCTYPE html>
<html lang="en">

<head>
    @include('client.template.meta')
    @include('client.template.css')
</head>

<body>
    @include('client.template.preloader')
    @include('client.template.humberger')
    @include('client.template.header')
    @include('client.template.hero')
    @yield('content')
    @include('client.template.footer')
    
    @include('client.template.script')
</body>

</html>