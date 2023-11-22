@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::settings.menus.title')
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::settings.menus.title'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="menus-table">
        @include('packages/core::settings.menus.menus_table')
    </div>
    @include('packages/core::medias.include._modal-open-media')
@endsection
