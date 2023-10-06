@extends('packages/core::layouts.app')
@section('content')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <i class="fa fa-eye"></i>
                <i class="fa-solid fa-pen-to-square"></i>
                <div class="card col-lg-4 mx-auto rounded">
                    <div class="card-body px-5 py-5">
                        <h3 class="card-title text-center mb-3">Login</h3>
                        <form id="form_login" class="mt-4" method="POST" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="form-group">
                                <label class="text-black" for="email">Email</label>
                                <input id="email" type="text" name="email" class="form-control" autocomplete="off" validate="true" validate-pattern="required|email" label="Email" />
                                <div id="error_email"></div>
                            </div>
                            <div class="form-group">
                                <label class="text-black" for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control" autocomplete="off" validate="true" validate-pattern="required" label="Password" />
                                <div id="error_password"></div>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        Remember me
                                        <input type="checkbox" class="form-check-input" style="border: 1px solid #0a0a0a;" />
                                    </label>
                                </div>
                                <a href="#" class="forgot-pass">Forgot password</a>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-facebook mr-2 col"><i class="mdi mdi-facebook"></i> Facebook</button>
                                <button class="btn btn-google col"><i class="mdi mdi-google-plus"></i> Google</button>
                            </div>
                            <p class="sign-up text-black">Don't have an Account?<a href="#"> Sign Up</a></p>
                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
    <!-- page-body-wrapper ends -->
    <!-- container-scroller -->
@endsection
