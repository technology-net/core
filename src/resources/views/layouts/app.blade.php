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
    <link rel="stylesheet" href="{{ mix('core/vendors/css/sweetalert2.min.css') }}" />
    <!-- end-inject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ mix('core/css/style.css') }}" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ mix('core/images/favicon.png') }}" />
    @yield('css')
</head>
<body>
<div class="container-scroller">
    @yield('content')
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ mix('core/vendors/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script src="{{ mix('core/vendors/js/sweetalert2.all.min.js') }}"></script>
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
<script type="text/javascript" src="{{ mix('core/js/validate.js') }}" defer></script>
<script type="text/javascript" src="{{ mix('core/js/login.js') }}" defer></script>
<script type="text/javascript" src="{{ mix('core/js/common.js') }}" defer></script>
<script type="text/javascript">
    let dashboard_url = '{{ route('dashboard.index') }}'
    let validateMessage = {!! json_encode(trans('packages/core::validation')) !!}
</script>
@yield('js')
</body>
</html>
