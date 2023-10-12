@php use IBoot\Core\app\Models\Plugin; @endphp
@extends('packages/core::layouts.admin')
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
                        <div class="card text-black">
                            <div>
                                <div class="app-icon">
                                    @if ($plugin->image)
                                        <img src="{{ asset($plugin->image) }}" alt="{{ $plugin->name_package }}">
                                    @endif
                                </div>
                                <div class="app-details">
                                    <h4 class="app-name">{{ $plugin->name_package }}</h4>
                                </div>
                            </div>
                            <div class="app-footer">
                                <div class="app-description" title="{{ $plugin->description }}">
                                    {{ $plugin->description }}
                                </div>
                                <div class="app-version">Version: {{ $plugin->version ?: '1.0.0' }}
                                </div>
                                <div class="app-actions">
                                    <button class="btn btn-warning btn-trigger-change-status"
                                        {{ $plugin->is_default ? 'disabled' : '' }}
                                        data-plugin="analytics" data-status="1">
                                        {{ $plugin->status === Plugin::STATUS_INSTALLED
                                            ? trans('packages/core::plugin.deactivate')
                                            : trans('packages/core::plugin.activate') }}
                                    </button>
                                    <button class="btn btn-link text-danger text-decoration-none btn-trigger-remove-plugin
                                        {{ $plugin->is_default ? 'disabled' : '' }}"
                                        data-plugin="analytics">{{ trans('packages/core::plugin.remove') }}
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
