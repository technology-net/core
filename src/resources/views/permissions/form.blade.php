@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::settings.system_settings.title')
@stop
@section('content')
    @php
        $label = !empty($permission->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::common.role_permission.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::common.role_permission.permissions.title'),
                'url' => route('permissions.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    @include('packages/core::partial.note', ['text' => trans('packages/core::messages.note', ['field' => $label])])
    <div class="form-create-user">
        <form method="POST" action="{{ route('permissions.update', $permission->id ?? 0) }}" id="formSubmitSimple">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $permission->id ?? 0 }}">
            <div class="border-white bg-white p-5">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="{{ trans('packages/core::common.name') }}" class="control-label text-black" aria-required="true">
                            {{ trans('packages/core::common.name') }}
                            <strong class="text-required text-danger">*</strong>
                        </label>
                        <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.name') }}" validate="true"
                               placeholder="{{ trans('packages/core::common.name') }}"
                               validate-pattern="required" name="name" type="text" value="{{ old('name', $permission->name ?? null) }}">
                        <div id="error_name"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-long-arrow-alt-left"></i>
                        {{ trans('packages/core::common.back') }}
                    </a>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">
                        @if(!empty($permission->id))
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
