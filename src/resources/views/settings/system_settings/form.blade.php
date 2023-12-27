@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::settings.system_settings.title')
@stop
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
    @include('packages/core::partial.note', ['text' => trans('packages/core::messages.note', ['field' => $label])])
    <div class="form-create-user">
        <form method="POST" action="{{ route('settings.system_settings.update', $systemSetting->id ?? 0) }}" id="formSubmitSimple">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $systemSetting->id ?? 0 }}">
            <div class="border-white bg-white p-5">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="{{ trans('packages/core::settings.system_settings.key') }}" class="control-label text-black" aria-required="true">
                            {{ trans('packages/core::settings.system_settings.key') }}
                            <strong class="text-required text-danger">*</strong>
                        </label>
                        <input class="form-control" autocomplete="off" label="{{ trans('packages/core::settings.system_settings.key') }}" validate="true"
                               placeholder="{{ trans('packages/core::settings.system_settings.key') }}"
                               validate-pattern="required" name="key" type="text" value="{{ old('key', $systemSetting->key ?? null) }}">
                        <div id="error_key"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="{{ trans('packages/core::common.group_name') }}" class="control-label text-black" aria-required="true">
                            {{ trans('packages/core::common.group_name') }}
                            <strong class="text-required text-danger">*</strong>
                        </label>
                        <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.group_name') }}" validate="true"
                               placeholder="{{ trans('packages/core::common.group_name') }}"
                               validate-pattern="required" name="group_name" type="text" value="{{ old('group_name', $systemSetting->group_name ?? null) }}">
                        <div id="error_group_name"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="{{ trans('packages/core::settings.system_settings.value') }}" class="control-label required text-black" aria-required="true">
                            {{ trans('packages/core::settings.system_settings.value') }}
                            <strong class="text-required text-danger">*</strong>
                        </label>
                        <textarea class="form-control" name="value" rows="10" label="{{ trans('packages/core::settings.system_settings.value') }}"
                                  placeholder="{{ trans('packages/core::settings.system_settings.value') }}" validate="true" validate-pattern="required">{{ old('key', $systemSetting->value ?? null) }}</textarea>
                        <div id="error_value"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <a href="{{ route('settings.system_settings.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-long-arrow-alt-left"></i>
                        {{ trans('packages/core::common.back') }}
                    </a>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">
                        @if(!empty($systemSetting->id))
                            <i class="fas fa-sync-alt"></i>
                        @else
                            <i class="fas fa-plus"></i>
                        @endif
                            {{ $label }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
