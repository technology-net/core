@extends('packages/core::layouts.admin')
@section('css')
    <link href="{{ mix('core/css/user.css') }}" rel="stylesheet" />
@endsection
@section('content')
    @include('packages/core::partial.breadcrumb', [
        'breadcrumbs' => [
            [
                'label' => trans('packages/core::user.users'),
                'url' => route('users.index'),
            ],
            [
                'label' => trans('packages/core::user.update_title'),
                'url' => null,
            ]
        ]
    ])
    <div class="clearfix"></div>
    <div>
        <div class="mx-1">
            @include('packages/core::partial.note', ['text' => trans('packages/core::user.update_user_note')])
        </div>
        <div class="form-create-user">
            <form method="POST" action="{{ route('users.update', ['user' => $user]) }}" id="updateFormUser">
                @csrf
                @method('PUT')
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
                                            validate-pattern="required" name="username" type="text" value="{{ $user->username }}" id="username">
                                        <div id="error_username"></div>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="email" class="control-label required text-black" aria-required="true">
                                            {{ trans('packages/core::user.email') }}
                                            <strong class="text-required text-danger">*</strong>
                                        </label>
                                        <input class="form-control" value="{{ $user->email }}" autocomplete="off" label="Email" validate="true"
                                            validate-pattern="required|email" placeholder="Ex: example@gmail.com"
                                            name="email" type="text" id="email">
                                        <div id="error_email"></div>
                                    </div>
                                    <div class="form-group mb-3 col-md-6">
                                        <label for="name" class="control-label required text-black mt-2" aria-required="true">
                                            {{ trans('packages/core::user.name') }}
                                            <strong class="text-required text-danger">*</strong>
                                        </label>
                                        <input class="form-control" value="{{ $user->name }}" autocomplete="off" label="Name" validate="true"
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
                            <button type="submit" name="submit" value="submit" class="btn btn-twitter">
                                <span data-action="create" data-href="">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="28px" width="20px"
                                         viewBox="0 0 24 24"><title>account-check-outline</title>
                                        <path
                                            fill="#ffffff"
                                            d="M21.1,12.5L22.5,13.91L15.97,20.5L12.5,17L13.9,15.59L15.97,17.67L21.1,12.5M11,4A4,
                                            4 0 0,1 15,8A4,4 0 0,1 11,12A4,4 0 0,1 7,8A4,4 0 0,1 11,4M11,6A2,2 0 0,0 9,
                                            8A2,2 0 0,0 11,10A2,2 0 0,0 13,8A2,2 0 0,0 11,6M11,13C11.68,13 12.5,13.09 13.41,
                                            13.26L11.74,14.93L11,14.9C8.03,14.9 4.9,16.36 4.9,17V18.1H11.1L13,
                                            20H3V17C3,14.34 8.33,13 11,13Z"/>
                                    </svg>
                                    {{ trans('packages/core::common.update') }}
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
        let route_index = "{!! route('users.index') !!}"
    </script>
    <script type="text/javascript" src="{{ mix('core/js/user.js') }}" defer></script>
@endsection
