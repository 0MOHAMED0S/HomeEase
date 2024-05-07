@extends('layouts.dashboard')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        a {
            text-decoration: none !important;
        }
        .topbar .top-navbar .navbar-nav>.nav-item>.nav-link {
            line-height: normal !important;
        }
    </style>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/js/uikit-icons.min.js"></script>
@endsection
@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                UIkit.notification({
                    message: '{{ session('success') }}',
                    status: 'success',
                    pos: 'top-right'
                });
            });
        </script>
    @endif
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{ asset('assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />

                        </span>
                    </a>
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav me-auto mt-md-0 ">
                        <li class="nav-item hidden-sm-down">
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (isset(auth()->user()->image->path))
                                <img src="{{ asset('storage/'.auth()->user()->image->path) }}" alt="user"
                                    class="profile-pic me-2">{{ auth()->user()->name }}
                            @else
                                    <td><span class="round" style="margin-right:10px;">
                                            <?php
                                            $name = auth()->user()->name;
                                            $firstCharacter = substr($name, 0, 1);
                                            echo $firstCharacter;
                                            ?>
                                        </span>{{ auth()->user()->name }}</td>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('company.dashboard') }}" aria-expanded="false"><i
                                    class="me-3 far fa-clock fa-fw" aria-hidden="true"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('company.dashboard.profile')}}" aria-expanded="false">
                                <i class="me-3 fa fa-user" aria-hidden="true"></i><span class="hide-menu">Profile</span></a>
                        </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                            href="{{ route('company.dashboard.myorders') }}" aria-expanded="false"><i
                                class="me-3 fa fa-table" aria-hidden="true"></i><span class="hide-menu">Orders</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('company.dashboard.mycompanies') }}" aria-expanded="false"><i
                                class="me-3 fa fa-table" aria-hidden="true"></i><span
                                class="hide-menu">My Companies</span></a></li>


                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="page-title mb-0 p-0">Orders</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Orders</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        <div class="text-end upgrade-btn">

                        </div>
                    </div>
                </div>
            </div>
            @if ($orders->count() >0 )
            <div class="container-fluid">
                <center><h3>{{$company->name}}/{{$company->category->name}}</h3></center>
                @if ($company->tybe == 'Contract')
                <div class="row">
                    <!-- column -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 style="    display: flex;
                                justify-content: space-between;"
                                    class="card-title">Contract Orders Table <center><h2 class="card-subtitle"><code style="font-size: 20px">{{$orders->count()}}</code></h2></center></h4>
                                <div class="table-responsive">
                                    <table class="table user-table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Code</th>
                                                <th class="border-top-0">Number Of Months </th>
                                                <th class="border-top-0">Name Of User</th>
                                                <th class="border-top-0">Price</th>
                                                <th class="border-top-0">Category</th>
                                                <th class="border-top-0">Nationality Of User</th>
                                                <th class="border-top-0">City</th>
                                                <th class="border-top-0">Date</th>
                                                <th class="border-top-0">Time</th>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                            @include('CompanyDashboard.orders.edit')
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->number_of_months }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->company->price }}</td>
                                                    <td>{{ $order->categorie->name }}</td>
                                                    <td>{{ $order->nationality }}</td>
                                                    <td>{{ $order->city }}</td>
                                                    <td>{{ $order->date }}</td>
                                                    <td>{{ $order->time }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Edit-{{ $order->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else

                <div class="row">
                    <!-- column -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 style="    display: flex;
                                justify-content: space-between;"
                                    class="card-title">Hourly Orders Table <center><h2 class="card-subtitle"><code style="font-size: 20px">{{$orders->count()}}</code></h2></center></h4>

                                <div class="table-responsive">
                                    <table class="table user-table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Code</th>
                                                <th class="border-top-0">Period</th>
                                                <th class="border-top-0">Number Of Hours </th>
                                                <th class="border-top-0">Name Of User</th>
                                                <th class="border-top-0">Price</th>
                                                <th class="border-top-0">Category</th>
                                                <th class="border-top-0">Nationality Of User</th>
                                                <th class="border-top-0">City</th>
                                                <th class="border-top-0">Date</th>
                                                <th class="border-top-0">Time</th>
                                                <th class="border-top-0">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->Period }}</td>
                                                    <td>{{ $order->number_of_hours }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->company->price }}</td>
                                                    <td>{{ $order->categorie->name }}</td>
                                                    <td>{{ $order->nationality }}</td>
                                                    <td>{{ $order->city }}</td>
                                                    <td>{{ $order->date }}</td>
                                                    <td>{{ $order->time }}</td>
                                                    <td>{{ $order->status }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>
            @endif
        </div>
    </div>

@endsection
@section('scripts')
    @if ($errors->has('name') || $errors->has('path'))
        <script>
            window.onload = function() {
                @if ($errors->has('name'))
                    UIkit.notification({
                        message: '{{ $errors->first('name') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif


                @if ($errors->has('path'))
                    UIkit.notification({
                        message: '{{ $errors->first('path') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif
            };
        </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection
