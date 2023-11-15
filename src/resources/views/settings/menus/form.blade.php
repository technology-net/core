@extends('packages/core::layouts.admin')
@php
    $label = !empty($menu->id) ? trans('packages/core::common.update') : trans('packages/core::common.create');
@endphp
@section('title')
    @lang('packages/core::settings.menus.title')
@stop
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
                                <label for="menu_type" class="control-label required" aria-required="true">
                                    {{ trans('packages/core::settings.menus.menu_type') }}
                                    <strong class="text-required text-danger">*</strong>
                                </label>
                                <input class="form-control" autocomplete="off" label="Username" validate="true"
                                       validate-pattern="required" name="username" type="text" placeholder="{{ trans('packages/core::settings.menus.menu_type') }}"
                                       value="{{ old('menu_type', $menu->menu_type ?? null) }}" id="menu_type">
                                <div id="error_menu_type"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="card">
                                        <div class="card-header" id="headingPage">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block btn-collapsed text-left" type="button" data-toggle="collapse" data-target="#collapsePage" aria-expanded="{{$pages->isNotEmpty()?'true':'false'}}" aria-controls="collapsePage">
                                                    {{ trans('plugin/cms::cms.page.screen') }}
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapsePage" class="collapse @if($pages->isNotEmpty()) show @endif" aria-labelledby="headingPage" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul class="list-group @if($pages->count() > 8) scroll-y @endif">
                                                    @foreach($pages as $item)
                                                        <li class="list-group-item p-2 my-1 border">{{ $item->title }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingCategory">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block btn-collapsed text-left" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                                                    {{ trans('plugin/cms::cms.category.screen') }}
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseCategory" class="collapse" aria-labelledby="headingCategory" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <ul class="list-group @if($categories->count() > 8) scroll-y @endif">
                                                    @foreach($categories as $item)
                                                        <li class="list-group-item p-2 my-1 border">{{ $item->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">

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
    <script type="text/javascript" src="{{ mix('cms/js/create-common.mix.js') }}"></script>
    <script type="text/javascript" src="{{ mix('core/js/jquery.nestable.mix.js') }}"></script>
    <script type="text/javascript" src="{{ mix('core/js/menu.mix.js') }}"></script>
    <script type="text/javascript">
        let ROUTE_IDX = "{!! route('settings.menus.index') !!}"
    </script>
@endsection
