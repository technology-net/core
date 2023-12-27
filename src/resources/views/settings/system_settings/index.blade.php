@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::settings.system_settings.title')
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::settings.system_settings.title'),
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div class="table-wrapper" id="list-setting">
        @include('packages/core::settings.system_settings.include._list')
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{ mix('core/js/system-setting.mix.js') }}"></script>
    <script type="text/javascript">
        let ROUTE_IDX = "{!! route('settings.system_settings.index') !!}";
    </script>
@endsection
