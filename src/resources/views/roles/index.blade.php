@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::common.role_permission.roles.title')
@stop
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::common.role_permission.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::common.role_permission.roles.title'),
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="menus-table">
        @include('packages/core::roles.include._list')
    </div>
@endsection
@section('js')
{{--    <script type="text/javascript" src="{{ mix('core/js/system-settings.mix.js') }}" defer></script>--}}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
@endsection
