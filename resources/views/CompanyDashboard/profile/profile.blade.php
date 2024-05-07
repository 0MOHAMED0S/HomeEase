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
                            {{-- <form class="app-search ps-3">
                                <input type="text" class="form-control" placeholder="Search for..."> <a
                                    class="srh-btn"><i class="ti-search"></i></a>
                            </form> --}}
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
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link "
                                href="{{ route('company.dashboard') }}" aria-expanded="false"><i
                                    class="me-3 far fa-clock fa-fw" aria-hidden="true"></i><span
                                    class="hide-menu">Dashboard</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                                href="{{ route('company.dashboard.profile') }}" aria-expanded="false">
                                <i class="me-3 fa fa-user" aria-hidden="true"></i><span class="hide-menu">Profile</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link "
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
                        <h3 class="page-title mb-0 p-0">Profile</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        {{-- <div class="text-end upgrade-btn">
                            <a href="https://www.wrappixel.com/templates/monsteradmin/"
                                class="btn btn-success d-none d-md-inline-block text-white" target="_blank">Upgrade to
                                Pro</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body profile-card">
                                <center class="mt-4">
                                    @if (isset(auth()->user()->image->path))
                                        <img src="{{ asset('storage/'.auth()->user()->image->path) }}" class="rounded-circle"
                                            width="150" />
                                    @else
                                        <td><span class="round" style="margin-right:10px;">
                                                <?php
                                                $name = auth()->user()->name;
                                                $firstCharacter = substr($name, 0, 1);
                                                echo $firstCharacter;
                                                ?>
                                            </span></td>
                                    @endif

                                    <h4 class="card-title mt-2">{{ auth()->user()->name }}</h4>
                                    <h6 class="card-subtitle">{{ auth()->user()->role }}</h6>
                                    <div class="row justify-content-center">
                                                                <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('update.company.profile') }}" method="post"
                                    class="form-horizontal form-material mx-2" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-md-12 mb-0"> image</label>
                                        <div class="col-md-12">
                                            <input type="file" class="form-control ps-0 form-control-line"
                                                name="path">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 mb-0"> Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="name"
                                                value="{{ old('name', auth()->user()->name) }}"
                                                placeholder="{{ auth()->user()->name }}"
                                                class="form-control ps-0 form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}"
                                                placeholder="{{ auth()->user()->email }}"
                                                class="form-control ps-0 form-control-line" name="example-email"
                                                id="example-email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 mb-0">Phone</label>
                                        <div class="col-md-12">
                                            <input type="text" name="phone"
                                                value="{{ old('phone', auth()->user()->phone) }}"
                                                placeholder="{{ auth()->user()->phone }}"
                                                class="form-control ps-0 form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12 d-flex">
                                            <button type="submit"
                                                class="btn btn-success mx-auto mx-md-0 text-white">Update
                                                Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body">
                                    <form method="POST" action="{{ route('update.company.password') }}" class="form-horizontal form-material mx-2">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-md-12 mb-0">Old Password</label>
                                            <div class="col-md-12">
                                                <input type="password" name="old_password" class="form-control ps-0 form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12 mb-0">New Password</label>
                                            <div class="col-md-12">
                                                <input type="password" name="new_password" class="form-control ps-0 form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12 mb-0">Confirm Password</label>
                                            <div class="col-md-12">
                                                <input type="password" name="new_password_confirmation" class="form-control ps-0 form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12 d-flex">
                                                <button type="submit" class="btn btn-success mx-auto mx-md-0 text-white">Update Password</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
            <footer class="footer text-center">
                © 2021 Monster Admin by <a href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="../assets/plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    @if ($errors->has('name') || $errors->has('path') || $errors->has('phone') || $errors->has('email') || $errors->has('old_password') || $errors->has('new_password') || $errors->has('new_password_confirmation'))
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

                @if ($errors->has('phone'))
                    UIkit.notification({
                        message: '{{ $errors->first('phone') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif

                @if ($errors->has('email'))
                    UIkit.notification({
                        message: '{{ $errors->first('email') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif

                @if ($errors->has('old_password'))
                    UIkit.notification({
                        message: '{{ $errors->first('old_password') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif

                @if ($errors->has('new_password'))
                    UIkit.notification({
                        message: '{{ $errors->first('new_password') }}',
                        status: 'danger',
                        pos: 'top-right'
                    });
                @endif

                @if ($errors->has('new_password_confirmation'))
                    UIkit.notification({
                        message: '{{ $errors->first('new_password_confirmation') }}',
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
