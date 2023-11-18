@extends('packages/core::layouts.app')
@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b class="h1">{{ config('app.name', 'ICI Admin') }}</b>
            </div>
            <div class="card-body">
                <form id="form_login" method="POST" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="input-group my-2">
                        <input id="email" type="text" name="email" class="form-control" autocomplete="off" validate="true" validate-pattern="required|email" label="Email" placeholder="Email" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div id="error_email"></div>
                    <div class="input-group my-2">
                        <input id="password" type="password" name="password" class="form-control" autocomplete="off" validate="true" validate-pattern="required" label="Password" placeholder="Password"/>
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
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
