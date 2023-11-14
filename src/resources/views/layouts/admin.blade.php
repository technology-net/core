<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name', 'ICI Admin'))</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ mix('core/plugins/fontawesome/css/all.min.css') }}">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{ mix('core/plugins/sweet-alert/sweetalert2.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ mix('core/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ mix('core/css/custom.css') }}">
    <link rel="shortcut icon" href="{{ mix('core/images/favicon.ico') }}" />
    @yield('css')
    @yield('media-css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>
        <!-- Preloader -->
{{--        <div class="preloader flex-column justify-content-center align-items-center">--}}
{{--            <img class="animation__wobble" src="{{ asset('core/images/logo.png') }}" alt="{{ config('core.copyright') }}" height="60" width="60">--}}
{{--        </div>--}}
        <!-- Navbar -->
        @include('packages/core::partial.navbar')
        <!-- Main Sidebar Container -->
        <x-sidebar/>
        <div class="content-wrapper">
            <!-- Breadcrumb -->
            @yield('breadcrumb')
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- Main Footer -->
        @include('packages/core::partial.footer')
    </div>
    <script>
        let VALIDATE_MESSAGE = {!! json_encode(trans('packages/core::validation')) !!};
        const DELETE_CONFIRM = "{{ trans('packages/core::messages.delete_confirm') }}";
        const BTN_CONFIRM = "{{ trans('packages/core::common.confirm') }}";
        const BTN_CANCEL = "{{ trans('packages/core::common.cancel') }}";
    </script>
    <!-- jQuery -->
    <script src="{{ mix('core/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ mix('core/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ mix('core/dist/js/adminlte.min.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ mix('core/plugins/sweet-alert/sweetalert2.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ mix('core/js/validate.js') }}" defer></script>
    <script type="text/javascript" src="{{ mix('core/js/common.js') }}" defer></script>
    @yield('js')
    @yield('media-js')
</body>
</html>
