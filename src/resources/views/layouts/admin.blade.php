<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>ICI Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ mix('core/vendors/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('core/vendors/css/vendor.bundle.base.css') }}" />
    <link rel="stylesheet" href="{{ mix('core/vendors/css/toastr.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('core/vendors/css/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ mix('core/vendors/css/select2.min.css') }}" />
    <!-- end-inject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ mix('core/css/style.css') }}" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ mix('core/images/favicon.png') }}" />
    @yield('css')
</head>
<body>
<div class="container-scroller">
    <!-- partials/sidebar -->
    @include('packages/core::partial.sidebar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partials/navbar -->
        @include('packages/core::partial.navbar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- content-wrapper ends -->
            <!-- partials/footer -->
            @include('packages/core::partial.footer')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ mix('core/vendors/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ mix('core/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ mix('core/vendors/js/toastr.min.js') }}"></script>
<script src="{{ mix('core/vendors/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ mix('core/vendors/js/select2.min.js') }}"></script>
<!-- end-inject -->
<!-- inject:js -->
<script src="{{ mix('core/js/off-canvas.js') }}"></script>
<script src="{{ mix('core/js/hoverable-collapse.js') }}"></script>
<script src="{{ mix('core/js/misc.js') }}"></script>
<script src="{{ mix('core/js/settings.js') }}"></script>
<script src="{{ mix('core/js/todolist.js') }}"></script>
<!-- end-inject -->
<!-- Custom js for this page -->
<script src="{{ mix('core/js/dashboard.js') }}"></script>
<!-- End custom js for this page -->
<script>
    let validateMessage = {!! json_encode(trans('packages/core::validation')) !!}
</script>
<script type="text/javascript" src="{{ mix('core/js/validate.js') }}" defer></script>
<script type="text/javascript" src="{{ mix('core/js/common.js') }}" defer></script>
@yield('js')
</body>
</html>
