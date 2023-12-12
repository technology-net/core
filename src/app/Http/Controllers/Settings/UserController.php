<?php

namespace IBoot\Core\App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Requests\User\UserRequest;
use IBoot\Core\App\Models\User;
use IBoot\Core\App\Services\RoleService;
use IBoot\Core\App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class UserController extends Controller
{
    private UserService $userService;
    private RoleService $role;

    /**
     * @param UserService $userService
     * @param RoleService $role
     */
    public function __construct(
        UserService $userService,
        RoleService $role
    )
    {
        $this->userService = $userService;
        $this->role = $role;
    }

    /**
     * Get user list
     *
     * @param Request $request
     * @return View|string
     */
    public function index(Request $request): View|string
    {
        $this->authorize('viewAny', User::class);
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
        $this->authorize('create', User::class);
        $roles = $this->role->getLists();

        return view('packages/core::settings.users.form', compact('roles'));
    }

    /**
     * Show a user
     *
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $this->authorize('edit', User::class);
        $user = $this->userService->showUser($id)->load('roles');
        $roles = $this->role->getLists();

        return view('packages/core::settings.users.form', compact('user', 'roles'));
    }

    /**
     * @param UserRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->userService->createOrUpdateUser($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
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
        DB::beginTransaction();
        try {
            $this->authorize('delete', User::class);
            $this->userService->deleteUser($id);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function deleteAll(Request $request): JsonResponse
    {
        $ids = $request->ids;
        DB::beginTransaction();
        try {
            $this->userService->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }
}
