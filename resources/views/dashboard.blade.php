@extends('layouts.dashboard')
@section('content')
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="absolute"
        data-header-position="absolute" data-boxed-layout="full">
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
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                                href="{{ route('admin.dashboard') }}" aria-expanded="false"><i
                                    class="me-3 far fa-clock fa-fw" aria-hidden="true"></i><span
                                    class="hide-menu">Dashboard</span></a></li>


                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.dashboard.profile') }}" aria-expanded="false">
                                <i class="me-3 fa fa-user" aria-hidden="true"></i><span class="hide-menu">Profile</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.dashboard.users.table') }}" aria-expanded="false"><i
                                    class="me-3 fa fa-table" aria-hidden="true"></i><span class="hide-menu">Users</span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('admin.dashboard.companies') }}" aria-expanded="false"><i
                                class="me-3 fa fa-table" aria-hidden="true"></i><span class="hide-menu">Companies</span></a>
                    </li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.dashboard.categories') }}" aria-expanded="false"><i
                                    class="me-3 fa fa-table" aria-hidden="true"></i><span
                                    class="hide-menu">Categories</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('admin.dashboard.orders') }}" aria-expanded="false"><i
                                    class="me-3 fa fa-table" aria-hidden="true"></i><span
                                    class="hide-menu">Orders</span></a></li>

                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link active"
                                        href="{{ route('admin.dashboard.messages') }}" aria-expanded="false"><i
                                            class="me-3 fa fa-table" aria-hidden="true"></i><span
                                            class="hide-menu"> Messages</span></a></li>
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
                        <h3 class="page-title mb-0 p-0">Dashboard</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-6 col-4 align-self-center">
                        <div class="text-end upgrade-btn">
                            {{-- <a href="https://www.wrappixel.com/templates/monsteradmin/"
                                class="btn btn-success d-none d-md-inline-block text-white" target="_blank">Upgrade to
                                Pro</a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <!-- Column -->
                    <div class="col-sm-6">
                        <a href="{{ route('admin.dashboard.companies') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Companies</h4>
                                    <div class="text-end">
                                        <h2 class="font-light mb-0"><i class="ti-arrow-up text-success"></i>
                                            {{ $companiesCount }}</h2>
                                        <span class="text-muted">All</span>
                                    </div>
                                    <span class="text-success"></span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <div class="col-sm-6">
                        <a href="{{ route('admin.dashboard.users.table') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Users</h4>
                                    <div class="text-end">
                                        <h2 class="font-light mb-0"><i class="ti-arrow-up text-success"></i>
                                            {{ $usersCount }}</h2>
                                        <span class="text-muted">All</span>
                                    </div>
                                    <span class="text-success"></span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-sm-6">
                        <a href="{{ route('admin.dashboard.categories') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Categories</h4>
                                    <div class="text-end">
                                        <h2 class="font-light mb-0"><i class="ti-arrow-up text-success"></i>
                                            {{ $categoriesCount }}</h2>
                                        <span class="text-muted">All</span>
                                    </div>
                                    <span class="text-success"></span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <div class="col-sm-6">
                        <a href="{{ route('admin.dashboard.orders') }}">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Orers</h4>
                                    <div class="text-end">
                                        <h2 class="font-light mb-0"><i class="ti-arrow-up text-info"></i>
                                            {{ $ordersCount }}</h2>
                                        <span class="text-muted">All</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-md-flex">
                                        <h4 class="card-title col-md-10 mb-md-0 mb-3 align-self-center">Company Users</h4>
                                        <div class="col-md-2 ms-auto">
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-5">
                                        <table class="table stylish-table no-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0" colspan="2">#</th>
                                                    <th class="border-top-0">Name</th>
                                                    <th class="border-top-0">Phone</th>
                                                    <th class="border-top-0">Company Name</th>
                                                    <th class="border-top-0">Company Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($companies as $company )
                                                <tr>
                                                    <td>{{$company->id}}</td>
                                                    @if (isset($company->user->image->path))
                                                    <td><img width="50" height="50" src="{{ asset('storage/'.$company->user->image->path) }}" alt="user"
                                                        class="profile-pic me-2"></td>
                                                @else
                                                        <td><span class="round" style="margin-right:10px;">
                                                                <?php
                                                                $name = $company->user->name;
                                                                $firstCharacter = substr($name, 0, 1);
                                                                echo $firstCharacter;
                                                                ?>
                                                            </span></td>
                                                    @endif
                                                    <td class="align-middle">
                                                        <h6>{{$company->user->name}}</h6>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6>{{$company->user->phone}}</h6>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6>{{$company->name}}</h6>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6>{{$company->category->name}}</h6>
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
                </div>
                <footer class="footer text-center">
                    © 2021 Monster Admin by <a href="https://www.wrappixel.com/">wrappixel.com</a>
                </footer>
            </div>
        </div>
    @endsection
