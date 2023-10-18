@extends('packages/core::layouts.admin')
@section('css')
    <link href="{{ mix('core/css/user.css') }}" rel="stylesheet" />
@endsection
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
                'label' => trans('packages/core::user.create_title'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        <div class="mx-1">
            @include('packages/core::partial.note', ['text' => trans('packages/core::user.create_user_note')])
        </div>
        <div class="form-create-user">
            <form method="POST" action="{{ route('settings.users.store') }}" id="submitFormUser">
                @csrf
                <div class="row border border-white bg-white mx-1">
                    <div class="col-12 mt-5 mb-4">
                        <div class="main-form container">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="username" class="control-label required text-black" aria-required="true">
                                            {{ trans('packages/core::user.username') }}
                                            <strong class="text-required text-danger">*</strong>
                                        </label>
                                        <input class="form-control" autocomplete="off" label="Username" validate="true"
                                               validate-pattern="required" name="username" type="text" value="" id="username">
                                        <div id="error_username"></div>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="email" class="control-label required text-black" aria-required="true">
                                            {{ trans('packages/core::user.email') }}
                                            <strong class="text-required text-danger">*</strong>
                                        </label>
                                        <input class="form-control" autocomplete="off" label="Email" validate="true"
                                            validate-pattern="required|email" placeholder="Ex: example@gmail.com"
                                            name="email" type="text" id="email">
                                        <div id="error_email"></div>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="name" class="control-label required text-black mt-2" aria-required="true">
                                            {{ trans('packages/core::user.name') }}
                                            <strong class="text-required text-danger">*</strong>
                                        </label>
                                        <input class="form-control" autocomplete="off" label="Name" validate="true"
                                            validate-pattern="required" name="name" type="text" id="name">
                                        <div id="error_name"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 container-fluid mb-4">
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" name="submit" value="submit" class="btn btn-success">
                                <span data-action="create" data-href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px"
                                        viewBox="0 0 24 24"><title>account-plus-outline</title>
                                        <path
                                            fill="#ffffff"
                                            d="M15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4M15,
                                            5.9C16.16,5.9 17.1,6.84 17.1,8C17.1,9.16 16.16,10.1 15,10.1A2.1,2.1 0 0,1 12.9,
                                            8A2.1,2.1 0 0,1 15,5.9M4,7V10H1V12H4V15H6V12H9V10H6V7H4M15,13C12.33,13 7,14.33 7,
                                            17V20H23V17C23,14.33 17.67,13 15,13M15,14.9C17.97,14.9 21.1,16.36 21.1,
                                            17V18.1H8.9V17C8.9,16.36 12,14.9 15,14.9Z"/>
                                    </svg>
                                    {{ trans('packages/core::common.create') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        let route_index = "{!! route('settings.users.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/user.js') }}" defer></script>
@endsection
