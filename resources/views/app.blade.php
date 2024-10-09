
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Default App')</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/images/logo.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    {{--put mix inside the asset --}}
    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset('/css/loader.css') }}">
    @yield('css')
    <style>
        .editable { border-bottom: 2px dotted #d92e2e;}
        .nowrap { white-space: nowrap; }
        .nav-header { color: #fddd35 !important; }
    </style>


<body class="hold-transition sidebar-mini content">
<div class="wrapper">
    <div id="loader-wrapper" style="z-index: 999999">
        <div id="loader"></div>
    </div>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link handle-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link handle-link" href="{{ url('/') }}">{{ env('APP_FULLNAME') }}</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link handle-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form action="#" method="post">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" value="" name="searchNumber" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link handle-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-bullhorn"></i>
                </a>
            </li>
        </ul>
    </nav>


    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="{{ url('/dashboard') }}" class="brand-link">
            <img src="{{ url('/images/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
        </a>

        <div class="sidebar">
            <form action="#" method="post">
                @csrf
                <div class="form-inline mt-3">
                    <div class="input-group">
                        <input class="form-control form-control-sidebar" type="text" value="" name="searchNumber" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-header">MAIN MENU</li>
                    <li class="nav-item">
                        <a href="{{ url('/dashboard') }}" class="nav-link handle-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ url('/notification') }}" class="nav-link handle-link">--}}
{{--                            <i class="fas fa-bullhorn nav-icon"></i>--}}
{{--                            <p>Notification</p>--}}
{{--                            <span class="right badge badge-danger">3</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ url('/beds') }}" class="nav-link handle-link">
                            <i class="fas fa-bed nav-icon"></i>
                            <p>Manage Beds</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/profiles') }}" class="nav-link handle-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Manage Residents</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/beds/assignment') }}" class="nav-link handle-link">
                            <i class="fas fa-user-check nav-icon"></i>
                            <p>Bed Assignments</p>
                        </a>
                    </li>


                    <li class="nav-header">REPORT</li>
                    <li class="nav-item">
                        <a href="{{ url('/report/payment') }}" class="nav-link handle-link">
                            <i class="fas fa-receipt nav-icon"></i>
                            <p>Bed Rental Overview</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/report/payment/history') }}" class="nav-link handle-link">
                            <i class="fas fa-history nav-icon"></i>
                            <p>Payment History</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/report/rental') }}" class="nav-link handle-link">
                            <i class="fas fa-clipboard-list nav-icon"></i>
                            <p>Rental Logs</p>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ url('/report/income') }}" class="nav-link handle-link">--}}
{{--                            <i class="fas fa-dollar-sign nav-icon"></i>--}}
{{--                            <p>Monthly Income</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ url('/report/residents') }}" class="nav-link handle-link">--}}
{{--                            <i class="fas fa-user-shield nav-icon"></i>--}}
{{--                            <p>Total Residents</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                    <li class="nav-header">SETTINGS</li>
                    <li class="nav-item">
                        <a href="#feesModal" data-toggle="modal" class="nav-link">
                            <i class="fas fa-money-bill-wave nav-icon"></i>
                            <p>Manage Fees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/users') }}" class="nav-link handle-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('settings/account') }}" class="nav-link handle-link">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>
                                Account Settings
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/logout') }}" class="nav-link handle-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

    </aside>

    <div class="content-wrapper pt-3">
        <div class="content">
            <div class="container-fluid" id="content">
                @yield('main')
            </div>
        </div>

    </div>

    <footer class="main-footer">

        <div class="float-right d-none d-sm-inline">
            Developed by: D3zTro
        </div>

        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
</div>


@include('modal.fees')
{{--put mix inside the asset --}}
<script src="{{ asset(mix('/js/app.js')) }}"></script>
@include('js.handleUrl')
@include('js.fees')
@yield('js')
</body>
</html>
