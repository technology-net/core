<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\UnauthorizedException;
use IBoot\Core\App\Http\Requests\Auth\LoginRequest;
use IBoot\Core\App\Http\Requests\Auth\PasswordRequest;
use IBoot\Core\App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Carbon;

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

    public function htmlChangePassword()
    {
        return view('packages/core::auth.first-time-password');
    }

    /**
     * @param PasswordRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException
     */
    public function changePasswordFirstTime(PasswordRequest $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $token = $request->get('token');
        $newPassword = $request->get('new_password');

        if (!empty($email) && !empty($password) && !empty($newPassword) && !empty($token)) {
            $user = User::query()->where('email', $email)->first();
            $resetRecord = \DB::table('password_reset_tokens')->where('email', $email)->first();

            if (!empty($resetRecord)) {
                // Nếu tồn tại token thì check tiếp đến password có khớp hay không?
                if (!empty($user) && Hash::check($password, $user->password)) {
                    $createdTime = Carbon::parse($resetRecord->created_at);
                    // Nếu thời gian hiện tại - thời gian tạo token > config('auth.passwords.users.expire') thì báo lỗi token hết hạn
                    if (now()->diffInMinutes($createdTime) > config('auth.passwords.users.expire')) {
                        throw new UnauthorizedException(null, trans('packages/core::messages.token_expired'));
                    }
                    $user->password = Hash::make($newPassword);
                    $user->save();
                    Password::deleteToken($user);

                    return responseSuccess(null, trans('packages/core::messages.save_success'));
                } else {
                    throw new UnauthorizedException(null, trans('packages/core::messages.password_incorrect'));
                }
            } else {
                throw new UnauthorizedException(null, trans('packages/core::messages.token_used'));
            }
        }

        throw new UnauthorizedException(null, trans('packages/core::messages.action_error'));
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
