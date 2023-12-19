<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Requests\PermissionRequest;
use IBoot\Core\App\Services\PermissionService;
use IBoot\Core\App\Services\RoleService;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PermissionController extends Controller
{
    private PermissionService $permission;
    private RoleService $role;

    /**
     * @param PermissionService $permission
     * @param RoleService $role
     */
    public function __construct(
        PermissionService $permission,
        RoleService $role
    )
    {
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * @return View|string
     */
    public function index(): View|string
    {
        $this->authorize('viewAny', Permission::class);
        $permissions = $this->permission->getLists();

        return view('packages/core::permissions.index', compact('permissions'));
    }

    public function create(): View
    {
        $this->authorize('create', Permission::class);
        $roles = $this->role->getLists();

        return view('packages/core::permissions.form', compact('roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('edit', Permission::class);
        $permission = $this->permission->getById($id)->load('roles');
        $roles = $this->role->getLists();

        return view('packages/core::permissions.form', compact('permission', 'roles'));
    }


    /**
     * @param RoleRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(PermissionRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->permission->createOrUpdatePermission($id, $request->all());
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.save_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function destroy(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->authorize('delete', Permission::class);
            $this->permission->deletePermission($id);
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
            $this->permission->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }
}
