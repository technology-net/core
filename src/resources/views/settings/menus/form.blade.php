@extends('packages/core::layouts.admin')
@php
    $label = !empty($menu->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
@endphp
@section('title')
    @lang('packages/core::settings.menus.title')
@stop
@section('css')
    <link href="{{ mix('core/css/nestable.mix.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::settings.title'),
                'url' => '#',
            ],
            [
                'label' => trans('packages/core::settings.menus.title'),
                'url' => route('settings.menus.index'),
            ],
            [
                'label' => $label,
            ]
        ]
    ])
    <div class="clearfix"></div>
    @include('packages/core::partial.note', ['text' => trans('packages/core::messages.note', ['field' => $label])])
    <div class="form-create-user">
        <form method="POST" action="{{ route('settings.menus.update', $menu->id ?? 0) }}" id="formSubmit">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $menu->id ?? 0 }}">
            <div class="border-white bg-white p-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="{{ trans('packages/core::settings.menus.menu_type') }}" class="control-label required" aria-required="true">
                                    {{ trans('packages/core::settings.menus.menu_type') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="{{ trans('packages/core::settings.menus.menu_type') }}" validate="true"
                                       validate-pattern="required" name="menu_type" type="text" placeholder="{{ trans('packages/core::settings.menus.menu_type') }}"
                                       value="{{ old('menu_type', $menu->menu_type ?? null) }}">
                                <div id="error_menu_type"></div>
                                <div class="border p-3 mt-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="{{ trans('packages/core::common.name') }}" class="control-label required" aria-required="true">
                                                {{ trans('packages/core::common.name') }}
                                                <strong class="text-required text-danger">*</strong>
                                            </label>
                                            <input class="form-control" autocomplete="off" label="name" validate="true"
                                                   validate-pattern="required" type="text" placeholder="{{ trans('packages/core::common.name') }}"
                                                   value="" id="menu-item-name">
                                            <div id="error_name"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="{{ trans('packages/core::common.url') }}" class="control-label">
                                                {{ trans('packages/core::common.url') }}
                                            </label>
                                            <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.url') }}"
                                                   type="text" placeholder="{{ trans('packages/core::common.url') }}" value="" id="menu-item-url">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="{{ trans('packages/core::common.icon') }}" class="control-label">
                                                {{ trans('packages/core::common.icon') }}
                                            </label>
                                            <input class="form-control" autocomplete="off" label="{{ trans('packages/core::common.icon') }}"
                                                   type="text" placeholder="{{ trans('packages/core::common.icon') }}" value="" id="menu-item-icon">
                                        </div>
                                    </div>

                                    <div class="text-right mt-3">
                                        <button type="button" class="btn btn-secondary btn-sm" id="reset-item">
                                            <i class="fas fa-sync-alt"></i>
                                            {{ trans('packages/core::common.reset') }}
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" id="add-item">
                                            <i class="fas fa-plus"></i>
                                            {{ trans('packages/core::settings.menu_item.add') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="@lang('packages/core::settings.menu_item.title')" class="control-label">
                                    {{ trans('packages/core::settings.menu_item.title') }}
                                </label>
                                <div class="dd" id="nestable">
                                    <ol class="dd-list @if(!empty($menuItems) && $menuItems->count() > 11) scroll-y @endif">
                                        @if(!empty($menuItems))
                                            @foreach($menuItems as $item)
                                                <li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-url="{{ $item->url }}" data-icon="{{ $item->icon }}">
                                                    <div class="dd-handle form-control">{{ $item->name }}</div>
                                                    <div class="input-group-append dd-item-group">
                                                        <span class="input-group-text btn btn-danger button-delete">
                                                            <i class="fas fa-times" aria-hidden="true"></i>
                                                        </span>
                                                        <span class="input-group-text btn btn-info button-edit">
                                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                                        </span>
                                                    </div>
                                                    @if($item->children->isNotEmpty())
                                                        <ol class="dd-list" is-child="true">
                                                            @foreach($item->children as $child)
                                                                <li class="dd-item" data-id="{{ $child->id }}" data-name="{{ $child->name }}" data-url="{{ $child->url }}" data-icon="{{ $child->icon }}">
                                                                    <div class="dd-handle form-control">{{ $child->name }}</div>
                                                                    <div class="input-group-append dd-item-group">
                                                                        <span class="input-group-text btn btn-danger button-delete">
                                                                            <i class="fas fa-times" aria-hidden="true"></i>
                                                                        </span>
                                                                        <span class="input-group-text btn btn-info button-edit">
                                                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('settings.menus.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-long-arrow-alt-left"></i>
                        {{ trans('packages/core::common.back') }}
                    </a>
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">
                        @if(!empty($menu->id))
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
    <script type="text/javascript" src="{{ mix('core/js/jquery.nestable.mix.js') }}"></script>
    <script type="text/javascript" src="{{ mix('core/js/menu.mix.js') }}"></script>
    <script type="text/javascript">
        let ROUTE_IDX = "{!! route('settings.menus.index') !!}";
        let TEXT_ADD_ITEM = "<i class='fas fa-plus'></i> {{ trans('packages/core::settings.menu_item.add') }}";
        let TEXT_EDIT_ITEM = "<i class='fas fa-pencil-alt'></i> {{ trans('packages/core::settings.menu_item.edit') }}";
    </script>
@endsection
