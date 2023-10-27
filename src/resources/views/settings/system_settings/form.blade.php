@extends('packages/core::layouts.admin')
@section('content')
    @php
        $label = !empty($systemSetting->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::settings.system_settings.title'),
                'url' => route('settings.system_settings.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        <div class="mx-1">
            @include('packages/core::partial.note', ['text' => trans('packages/core::settings.system_settings.note', ['field' => $label])])
        </div>
        <div class="form-create-user">
            <form method="POST" action="{{ route('settings.system_settings.update', $systemSetting->id ?? 0) }}" id="formSubmit">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $systemSetting->id ?? 0 }}">
                <div class="border-white bg-white p-5">
                    <div class="container">
                        <div class="row">
                            <div class="form-group pb-4 col-md-6">
                                <label for="{{ trans('packages/core::settings.system_settings.key') }}" class="control-label text-black" aria-required="true">
                                    {{ trans('packages/core::settings.system_settings.key') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="{{ trans('packages/core::settings.system_settings.key') }}" validate="true"
                                       validate-pattern="required" name="key" type="text" value="{{ old('key', $systemSetting->key ?? null) }}">
                                <div id="error_key"></div>
                            </div>
                            <div class="form-group pb-4 col-md-6">
                                <label for="{{ trans('packages/core::settings.system_settings.value') }}" class="control-label required text-black" aria-required="true">
                                    {{ trans('packages/core::settings.system_settings.value') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <textarea class="form-control" name="value" rows="10" label="{{ trans('packages/core::settings.system_settings.value') }}" validate="true" validate-pattern="required">{{ old('key', $systemSetting->value ?? null) }}</textarea>
                                <div id="error_value"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('settings.system_settings.index') }}" class="btn btn-secondary">
                            <span class="mdi mdi-arrow-left"></span>
                            {{ trans('packages/core::common.back') }}
                        </a>
                        <button type="submit" name="submit" value="submit" class="btn btn-success">
                        @if(!empty($systemSetting->id))
                                <span class="mdi mdi-sync"></span>
                            @else
                                <span class="mdi mdi-plus"></span>
                            @endif
                                {{ $label }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        const ROUTE_IDX = "{!! route('settings.system_settings.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/system-settings.js') }}" defer></script>
@endsection
