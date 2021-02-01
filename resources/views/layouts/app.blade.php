<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/vendor/dist/css/submit.css">
    <link rel="stylesheet" href="/vendor/plugins/fontawesome-free/css/all.min.css">
</head>
<body>
    @if (file_exists(public_path('/storage/product_images/no_image.png')) && file_exists(public_path('/storage/beep-07.wav')))
    <div class="container-fluid">
        @yield('content')
    </div>
    <div style="position: absolute;bottom:0;"><strong>Copyright © <span id="year"></span> RonDevIT </strong> </div>
    <span style="position: absolute;right:0;bottom:0;"><strong>Contact #09355302505</strong></span>
    @else
        <h1 style="font-family:fantasy;font-size:60px">BEWARE! THIS IS ILLEGAL!!!</h1>
        <h1 style="font-family:Fantasy;color:red">
            PLEASE DO NOT COPY THE PROGRAM! <br>
            THIS PROGRAM HAS A COPY RIGHT!
            <br><br>
            PLEASE DO NOT COPY THE PROGRAM! <br>
            THIS PROGRAM HAS A COPY RIGHT!
            <br>
            <br>
            PLEASE DO NOT COPY THE PROGRAM! <br>
            THIS PROGRAM HAS A COPY RIGHT!
            <br>
        </h1>
        <h1 style="font-family:fantasy;font-size:60px">PLEASE CONTACT THE DEVELOPER!</h1> <br>
        <h2>CONTACT NO. #09355302505</h2>
    @endif
   

<script src="/vendor/plugins/jquery/jquery.min.js"></script>   
<script>
    let date = new Date();
    $('#year').text(date.getFullYear());
  </script> 
@yield('script')
</body>
</html>