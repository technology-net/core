@extends('packages/core::layouts.app')
@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b class="h1">{{ config('app.name', 'ICI Admin') }}</b>
            </div>
            <div class="card-body">
                <form id="form_login" method="POST" action="{{ route('change-pass-first-time') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->get('token') }}">
                    <input type="hidden" name="email" value="{{ request()->get('email') }}">
                    <div class="input-group my-2">
                        <input type="password" name="password" class="form-control" autocomplete="new-password" validate="true" label="@lang('packages/core::common.password')" placeholder="@lang('packages/core::common.password')"
                        value="" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_password"></div>
                    <div class="input-group my-2">
                        <input type="password" name="new_password" class="form-control" autocomplete="new-password" validate="true" label="@lang('packages/core::common.new_password')" placeholder="@lang('packages/core::common.new_password')"
                               value="" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_new_password"></div>
                    <div class="input-group my-2">
                        <input type="password" name="confirm_password" class="form-control" autocomplete="new-password" validate="true" label="@lang('packages/core::common.confirm_password')" placeholder="@lang('packages/core::common.confirm_password')"
                               value="" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_password_confirmation"></div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">@lang('packages/core::common.confirm')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
