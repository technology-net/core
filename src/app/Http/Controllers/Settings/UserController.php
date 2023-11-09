<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Requests\User\UserRequest;
use IBoot\Core\App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Get user list
     *
     * @param Request $request
     * @return View|string
     */
    public function index(Request $request): View|string
    {
        $users = $this->userService->getUsers();

        if ($request->ajax()) {
            return view('packages/core::settings.users.user_table', ['users' => $users])->render();
        }

        return view('packages/core::settings.users.index', ['users' => $users]);
    }

    /**
     * Create screen
     *
     * @return View
     */
    public function create(): View
    {
        return view('packages/core::settings.users.create');
    }

    /**
     * Create a new user
     *
     * @param UserRequest $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userService->newUser($request->validated());
        if (!$user) {
            throw new ServerErrorException(null, trans('packages/core::messages.create_user_fail'));
        }

        return responseSuccess(null, trans('packages/core::messages.create_user_success'));
    }

    /**
     * Show a user
     *
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $user = $this->userService->showUser($id);

        return view('packages/core::settings.users.detail', ['user' => $user]);
    }

    /**
     * Update a user
     *
     * @param UserRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(UserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->all());
        if (!$user) {
            throw new ServerErrorException(null, trans('packages/core::messages.update_user_fail'));
        }

        return responseSuccess(null, trans('packages/core::messages.update_user_success'));
    }


    /**
     * Delete a user
     *
     * @param int $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function destroy(int $id): JsonResponse
    {
        $user = $this->userService->deleteUser($id);
        if (!$user) {
            throw new ServerErrorException(null, trans('packages/core::messages.delete_user_fail'));
        }

        return responseSuccess(null, trans('packages/core::messages.delete_user_success'));
    }
}
