<?php

namespace IBoot\Core\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\RedirectResponse;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission): Response|RedirectResponse
    {
        $permissions = is_array($permission) ? $permission : explode('|', $permission);

        if (!Auth::user()->canAny($permissions)) {
            return response()->view('packages/core::errors.403');
        }

        return $next($request);
    }

    /**
     * @param $permission
     * @return string
     */
    public static function using($permission): string
    {
        $permissionString = is_string($permission) ? $permission : implode('|', $permission);

        return static::class . ':' . $permissionString;
    }
}
