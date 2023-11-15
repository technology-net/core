@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::user.users')
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::user.users'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="user-table">
        @include('packages/core::settings.users.user_table')
    </div>
@endsection
@section('js')
    <script type="text/javascript">
      let ROUTE_IDX = "{!! route('settings.users.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/user.mix.js') }}" defer></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
@endsection
