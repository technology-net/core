<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\UnauthorizedException;
use IBoot\Core\App\Http\Requests\Auth\LoginRequest;
use IBoot\Core\App\Models\User;
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
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $input = $loginRequest->all();
        $remember = $loginRequest->has('remember') ? true : false;
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
            'status' => User::STATUS_ACTIVATED,
        ];
        if(Auth::attempt($credentials, $remember)) {
            $this->storeSession();
            return responseSuccess(null, trans('packages/core::messages.login_success'));
        }

        throw new UnauthorizedException(null, trans('packages/core::messages.login_failed'));
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return Redirector|Application|RedirectResponse
     */
    public function logout(Request $request): Redirector|Application|RedirectResponse
    {
        Auth::logout();
        $remember = session('remember');
        $email = session('email_admin');
        $password = session('password');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (!empty($remember)) {
            session()->put('remember', $remember);
            session()->put('email_admin', $email);
            session()->put('password', $password);
        }

        return redirect()->route('auth.index');
    }

    private function storeSession()
    {
        $user = Auth::user();
        $remember = request()->has('remember') ? true : false;
        if (!empty($remember)) {
            session()->put('password', request()->get('password'));
        }
        $avatar = $user->medias->isNotEmpty() ? $user->medias[0]->image_sm : '';
        if (!empty($avatar)) {
            session()->put('avatar_' . $user->id, $avatar);
        }
        session()->put('remember', $remember);
        session()->put('user_id', $user->id);
        session()->put('person_name', $user->name);
        session()->put('email_admin', $user->email);
    }
}
