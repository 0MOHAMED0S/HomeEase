@extends('layouts.auth')
@section('styles')
<link rel="stylesheet" href="{{asset('css/auth.css')}}">
<link rel="stylesheet" href="{{asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
@endsection
@section('content')
<div class="wrapper" style="background-image: url('{{asset('mainImages/bg-registration-form-1.jpg')}}');">

    <div class="inner">
        <div class="image-holder">
            <img src="{{asset('mainImages/registration-form-1.jpg')}}" alt="">
        </div>
        <form method="POST" action="{{ route('admin.login.store') }}">
            @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
            @csrf

            <h3>Admin Login Form</h3>
            <div class="form-group">
                <input type="email" placeholder="Email" class="form-control" type="email" name="email" value="{{old('email')}}">
                <i class="zmdi zmdi-email"></i>
            </div>
            <center>OR</center>
            <div class="form-group">
                <input type="text" placeholder="phone" class="form-control" name="phone" value="{{old('phone')}}">
                <i class="zmdi zmdi-phone"></i>
            </div>
            <div class="form-wrapper">
                <input type="password" placeholder="Password" class="form-control"  type="password" name="password">
                <i class="zmdi zmdi-lock"></i>
            </div>
            <button>Login
                <i class="zmdi zmdi-arrow-right"></i>
            </button>
            <br>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul style="color: red">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </form>
    </div>
</div>

@endsection
@section('scripts')
@endsection

