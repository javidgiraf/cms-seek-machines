<!doctype html>
<html class="no-js " lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>:: Seek Machines Admin :: Home</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{asset('frontend/assets/plugins/bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}" />
    <link rel="stylesheet" href="{{asset('frontend/assets/plugins/charts-c3/plugin.css')}}" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('frontend/assets/plugins/morrisjs/morris.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/custom.css')}}">
    @stack('styles')
    @livewireStyles
</head>

<body class="theme-blush">

    <!-- Page Loader -->


    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Main Search -->
    <div id="search">
        <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
        <form>
            <input type="search" value="" placeholder="Search..." />
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Right Icon menu Sidebar -->
    <div class="navbar-right">
        <ul class="navbar-nav">





            <li><a href="javascript:void(0);" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="mega-menu" title="Sign Out"><i class="zmdi zmdi-power"></i></a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </ul>
    </div>

    <!-- Left Sidebar -->
    <!-- Horizontal Nav -->
    @include('layouts.partials._header')
    <!-- /Horizontal Nav -->

    <!-- Right Sidebar -->

    @yield('content')
    <!-- Jquery Core Js -->
    <script src="{{asset('frontend/assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="{{asset('frontend/assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="{{asset('frontend/assets/bundles/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{asset('frontend/assets/bundles/sparkline.bundle.js')}}"></script> <!-- Sparkline Plugin Js -->
    <script src="{{asset('frontend/assets/bundles/c3.bundle.js')}}"></script>

    <script src="{{asset('frontend/assets/bundles/mainscripts.bundle.js')}}"></script>
    <script src="{{asset('frontend/assets/js/pages/index.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>

    @livewireScripts
    @stack('scripts')


</body>


</html>
