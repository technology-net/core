@extends('packages/core::layouts.app')
@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b class="h1">{{ config('app.name', 'ICI Admin') }}</b>
            </div>
            <div class="card-body">
                <form id="form_login" method="POST" action="{{ route('auth.login') }}" autocomplete="off">
                    @csrf
                    <input class="d-none" type="email" name="f_email">
                    <div class="input-group my-2">
                        <input id="email" type="text" name="email" class="form-control" autocomplete="off" validate="true" validate-pattern="required|email" label="@lang('packages/core::common.email')" placeholder="@lang('packages/core::common.email')"
                        value="{{ session('remember') ? session('email_admin') : '' }}" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_email"></div>
                    <div class="input-group my-2">
                        <input id="password" type="password" name="password" class="form-control" autocomplete="new-password" validate="true" validate-pattern="required" label="@lang('packages/core::common.password')" placeholder="@lang('packages/core::common.password')"
                        value="{{ session('remember') ? session('password') : '' }}" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_password"></div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" {{ session('remember') ? 'checked' : '' }}>
                                <label for="remember">@lang('packages/core::common.remember')</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">@lang('packages/core::common.login')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
