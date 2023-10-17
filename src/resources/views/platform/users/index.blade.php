@extends('packages/core::layouts.admin')
@section('css')
    <link href="{{ mix('core/css/user.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::user.users'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="user-table">
        @include('packages/core::platform.users.user_table')
    </div>
@endsection
@section('js')
    <script type="text/javascript">
      let route_index = "{!! route('users.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/user.js') }}" defer></script>
@endsection
