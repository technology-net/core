<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
    <link rel="shortcut icon" href="{{ mix('core/images/favicon.ico') }}" />
    @yield('css')
</head>
<body>
    <div class="login-page">
        @yield('content')
    </div>
    <script type="text/javascript">
        let DASHBOARD_URL = '{{ route('dashboard.index') }}'
        let VALIDATE_MESSAGE = {!! json_encode(trans('packages/core::validation')) !!}
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
    <script type="text/javascript" src="{{ mix('core/js/login.js') }}" defer></script>

    <script type="text/javascript" src="{{ mix('core/js/common.js') }}" defer></script>
    @yield('js')
</body>
</html>
