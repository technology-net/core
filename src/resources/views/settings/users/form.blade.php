@extends('packages/core::layouts.admin')
@php
    use IBoot\Core\App\Models\User;
    $label = !empty($user->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
    $roleSelected = !empty($user) && $user->roles->isNotEmpty() ? $user->roles->pluck('name')->toArray() : [];
@endphp
@section('title')
    @lang('packages/core::user.users')
@stop
@section('css')
    <link rel="stylesheet" href="{{ mix('core/plugins/select2/select2.min.css') }}">
@stop
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::user.users'),
                'url' => route('settings.users.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    @include('packages/core::partial.note', ['text' => trans('packages/core::messages.note', ['field' => $label])])
    <div class="form-create-user">
        <form method="POST" action="{{ route('settings.users.update', $user->id ?? 0) }}" id="submitFormUser">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id ?? 0 }}">
            <input type="hidden" name="role_selected" value="{{ json_encode($roleSelected) }}">
            <div class="border-white bg-white p-5">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username" class="control-label required" aria-required="true">
                                    {{ trans('packages/core::user.username') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="Username" validate="true"
                                       validate-pattern="required" name="username" type="text" placeholder="{{ trans('packages/core::user.username') }}"
                                       value="{{ old('username', $user->username ?? null) }}" id="username" @if(!empty($user)) readonly @endif>
                                <div id="error_username"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="control-label required" aria-required="true">
                                    {{ trans('packages/core::common.email') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="Email" validate="true"
                                       validate-pattern="required|email" placeholder="Ex: example@gmail.com"
                                       name="email" type="text" id="email" value="{{ old('email', $user->email ?? null) }}" @if(!empty($user)) readonly @endif>
                                <div id="error_email"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name" class="control-label required" aria-required="true">
                                    {{ trans('packages/core::common.name') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="Name" validate="true" placeholder="{{ trans('packages/core::common.name') }}"
                                       validate-pattern="required" name="name" type="text" id="name" value="{{ old('name', $user->name ?? null) }}">
                                <div id="error_name"></div>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status" class="control-label">
                                    {{ trans('packages/core::common.status') }}
                                </label>
                                <select class="form-control" name="status">
                                    <option value="{{ User::STATUS_ACTIVATED }}" @if(!empty($user) && $user->status == User::STATUS_ACTIVATED) selected @endif>{{ User::STATUS_ACTIVATED }}</option>
                                    <option value="{{ User::STATUS_DEACTIVATED }}" @if(!empty($user) && $user->status == User::STATUS_DEACTIVATED) selected @endif>{{ User::STATUS_DEACTIVATED }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="status" class="control-label">
                                    {{ trans('packages/core::common.level') }}
                                </label>
                                <select class="form-control" name="level">
                                    @foreach(levelOptions() as $level => $name)
                                        @if($level >= Auth::user()->level)
                                            <option value="{{ $level }}"
                                                    @if(!empty($user) && $user->level == $level || empty($user) && $level == User::NORMAL) selected @endif
                                                    @if(!empty($user) && $user->id == Auth::id() && $user->level == User::SUPER_HIGH) disabled @endif
                                            >
                                                {{ $name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @if(!empty($user))
                                <div class="form-group col-md-6">
                                    <label for="password" class="control-label required" aria-required="true">
                                        {{ trans('packages/core::common.password') }}
                                    </label>
                                    <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.password') }}" validate="true"
                                           validate-pattern="required" name="password" type="password" placeholder="{{ trans('packages/core::common.password') }}">
                                    <div id="error_password"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password" class="control-label required" aria-required="true">
                                        {{ trans('packages/core::common.confirm_password') }}
                                    </label>
                                    <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.confirm_password') }}" validate="true"
                                           validate-pattern="required" name="confirm_password" type="password" placeholder="{{ trans('packages/core::common.confirm_password') }}">
                                    <div id="error_confirm_password"></div>
                                </div>
                            @endif
                            <div class="form-group col-md-12">
                                <label for="{{ trans('packages/core::common.role_permission.roles.title') }}" class="control-label text-black" aria-required="true">
                                    {{ trans('packages/core::common.role_permission.roles.title') }}
                                </label>
                                <select class="form-control js-select2-multiple" name="roles[]" multiple="multiple">
                                    @foreach($roles as $item)
                                        <option data-id="{{ $item->id }}" value="{{ $item->name }}" @if(in_array($item->name, $roleSelected)) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div id="wrap-avatar">
                                <div class="preview-avatar">
                                    @if(!empty($user) && $user->medias->isNotEmpty())
                                        <img width="100%" src="{{ getPathImage($user->medias[0]->image_sm) }}" alt="{{ $user->medias[0]->name }}">
                                        <input type="hidden" name="media_id" value="{{ $user->medias[0]->id }}">
                                    @else
                                        <img width="100%" src="{{ asset('core/images/avatar-default.webp') }}" alt="avatar-default">
                                    @endif
                                    <i class="fas fa-camera" id="openMedia" data-avatar="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <a href="{{ route('settings.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-long-arrow-alt-left"></i>
                        {{ trans('packages/core::common.back') }}
                    </a>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">
                        @if(!empty($user->id))
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
    @include('packages/core::medias.include._modal-open-media')
@endsection
@section('js')
    <script type="text/javascript">
        let ROUTE_IDX = "{!! route('settings.users.index') !!}"
        const PLACEHOLDER = "{{ trans('packages/core::common.choose') }}";
    </script>
    <script src="{{ mix('core/plugins/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ mix('core/js/user.mix.js') }}" defer></script>
@endsection
