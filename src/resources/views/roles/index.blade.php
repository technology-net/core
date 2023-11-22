@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::common.role_permission.roles.title')
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
