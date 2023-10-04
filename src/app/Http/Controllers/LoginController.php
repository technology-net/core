<?php

namespace IBoot\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\app\Http\Requests\Auth\LoginRequest;
use IBoot\Core\app\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login view
     *
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        return view('packages/core::auth.login');
    }

    /**
     * Login
     *
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $input = $loginRequest->all();
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
            'status' => User::STATUS_ACTIVATED,
        ];

        $data = null;
        $statusResponse = Auth::attempt($credentials);
        $message = !Auth::attempt($credentials)
            ? trans('packages/core::messages.login_failed')
            : trans('packages/core::messages.login_success');

        return responseJson($data, $statusResponse, $message);
    }

    public function logout(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.index');
    }
}
