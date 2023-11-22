@extends('packages/core::layouts.admin')
@section('title')
    @lang('packages/core::common.role_permission.roles.title')
@stop
@section('content')
    @php
        $label = !empty($role->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
        $permissionSelected = !empty($role) && $role->permissions->isNotEmpty() ? $role->permissions->pluck('name')->toArray() : [];
    @endphp

    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::common.role_permission.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::common.role_permission.roles.title'),
                'url' => route('roles.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    @include('packages/core::partial.note', ['text' => trans('packages/core::messages.note', ['field' => $label])])
    <div class="form-create-user">
        <form method="POST" action="{{ route('roles.update', $role->id ?? 0) }}" id="formSubmitSimple">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $role->id ?? 0 }}">
            <input type="hidden" name="permission_selected" value="{{ json_encode($permissionSelected) }}">
            <div class="border-white bg-white p-5">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="{{ trans('packages/core::common.name') }}" class="control-label text-black" aria-required="true">
                            {{ trans('packages/core::common.name') }}
                            <strong class="text-required text-danger">*</strong>
                        </label>
                        <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.name') }}" validate="true"
                               placeholder="{{ trans('packages/core::common.name') }}"
                               validate-pattern="required" name="name" type="text" value="{{ old('name', $role->name ?? null) }}">
                        <div id="error_name"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="{{ trans('packages/core::common.role_permission.permissions.title') }}" class="control-label text-black" aria-required="true">
                            {{ trans('packages/core::common.role_permission.permissions.title') }}
                        </label>
                        <div class="border p-3">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="permission-all" @if(count($permissions) == count($permissionSelected)) checked @endif>
                                <label for="permission-all" class="form-check-label">{{ trans('packages/core::common.all') }}</label>
                            </div>
                            <div class="row">
                                @foreach($permissions as $item)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input permission-item"
                                                   @if(in_array($item->name, $permissionSelected)) checked @endif
                                                   type="checkbox" id="permission-{{ $item->id }}" name="permissions[]" value="{{ $item->name }}">
                                            <label for="permission-{{ $item->id }}" class="form-check-label">{{ $item->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-long-arrow-alt-left"></i>
                        {{ trans('packages/core::common.back') }}
                    </a>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">
                        @if(!empty($role->id))
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
@section('js')
    <script src="{{ mix('core/js/role.mix.js') }}" defer></script>
@endsection
