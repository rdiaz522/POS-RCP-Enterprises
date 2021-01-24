@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-4">

        </div>
        <div class="col-lg-4">
            <br>
           <div class="card">
               <div class="card-body">
                <span style="font-size:25px;color:green;font-weight:600">POS <i class="fas fa-shopping-cart"></i></span> <span style="font-family:Fantasy">by RonDevIT</span>
                <br>
                <h3 style="font-family: Cursive">RCP ENTERPRISE</h3><br>
                @if (session('error'))
                    <span style="color:red;font-family:sans-serif">{{session("error")}}</span>
                 @endif
               <form action="{{route('login')}}" class="prevent-double-form" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="username" style="font-family: sans-serif">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password"  style="font-family: sans-serif">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary float-right prevent-double-button" ><i class="spinner fas fa-spinner fa-spin"></i> Login</button>
                </form>
               </div>
           </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.spinner').hide();
            $('.prevent-double-button').one('click', function(e){
                e.preventDefault();
                $('.spinner').show();
                $(this).attr("disabled", true);
                $('.prevent-double-form').submit();
            })
        });
    </script>
@endsection