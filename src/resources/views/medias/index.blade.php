@extends('packages/core::layouts.admin')
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => 'Media',
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
