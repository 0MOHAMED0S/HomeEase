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
        <form id="form">
            <h3>WELCOME</h3>
            @auth
            <button>
                <a href="{{route('company.dashboard')}}">Dashboard</a>
            </button>
            @else
            <button>
                <a href="{{route('company.login')}}">Login</a>
            </button>
            @endauth
            <br>
            <br>
        </form>
    </div>
</div>

@endsection

