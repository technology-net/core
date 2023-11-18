@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::common.media.title')
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::common.media.title'),
                'url' => null,
            ]
        ]
    ])
    @include('packages/core::medias.include._html-media')
@endsection
@section('js')
    <script>
        const IS_MEDIA = true;
    </script>
@endsection
