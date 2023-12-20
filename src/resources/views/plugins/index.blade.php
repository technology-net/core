@php use IBoot\Core\App\Models\Plugin; @endphp
@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::plugin.plugins')
@stop
@section('css')
    <link rel="stylesheet" href="{{ mix('core/css/plugin.mix.css') }}">
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::plugin.plugins'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div id="plugin-list">
        <div class="mb-3">
            @include('packages/core::partial.note', ['text' => trans('packages/core::plugin.plugin_note')])
        </div>
        <div class="row">
            @foreach($plugins as $plugin)
                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="app-item app-{{ $plugin->name_package }}">
                        <div class="text-black">
                            <div class="app-icon">
                                @if ($plugin->image)
                                    <img src="{{ asset($plugin->image) }}" alt="{{ $plugin->name_package }}">
                                @endif
                            </div>
                            <div class="app-details">
                                <h4 class="app-name">{{ $plugin->name_package }}</h4>
                            </div>
                            <div class="app-footer">
                                <div class="app-description" title="{{ $plugin->description }}">
                                    {{ $plugin->description }}
                                </div>
                                <div class="app-version">Version: {{ $plugin->version ?: 'dev-main' }}
                                </div>
                                <div class="app-actions">
                                    <button class="btn btn-warning btn-trigger-change-status
                                        {{ $plugin->status !== Plugin::STATUS_INSTALLED
                                            ? 'btn-trigger-install-plugin'
                                            : 'btn-trigger-uninstall-plugin' }}"
                                        {{ $plugin->is_default || $plugin->status === Plugin::STATUS_INSTALLED ? 'disabled' : '' }}
                                            data-plugin_id="{{ $plugin->id }}"
                                            data-name_package="{{ $plugin->name_package }}"
                                            data-composer_name="{{ $plugin->composer_name }}"
                                            data-version="{{ $plugin->version }}"
                                            data-menu_items="{{ json_encode($plugin->menu_items) }}">
                                        {{ trans('packages/core::plugin.activate') }}
                                    </button>
                                    <button class="btn btn-danger btn-trigger-remove-plugin"
                                        {{ $plugin->is_default || $plugin->status !== Plugin::STATUS_INSTALLED ? 'disabled' : '' }}
                                            data-plugin_id="{{ $plugin->id }}"
                                            data-composer_name="{{ $plugin->composer_name }}"
                                            data-version="{{ $plugin->version }}"
                                            data-name_package="{{ $plugin->name_package }}"
                                            data-plugin="analytics">{{ trans('packages/core::plugin.deactivate') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        let route_install_package = "{!! route('plugins.install-packages') !!}"
        let route_uninstall_package = "{!! route('plugins.uninstall-packages') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/plugin.mix.js') }}" defer></script>
@endsection
