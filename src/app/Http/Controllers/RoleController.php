<?php

namespace IBoot\Core\App\Http\Controllers;

use App\Http\Controllers\Controller;
use IBoot\Core\App\Exceptions\ServerErrorException;
use IBoot\Core\App\Http\Requests\RoleRequest;
use IBoot\Core\App\Services\PermissionService;
use IBoot\Core\App\Services\RoleService;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleController extends Controller
{
    private RoleService $role;
    private PermissionService $permission;

    /**
     * @param RoleService $role
     * @param PermissionService $permission
     */
    public function __construct(
        RoleService $role,
        PermissionService $permission
    )
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * @return View|string
     */
    public function index(): View|string
    {
        $this->authorize('viewAny', Role::class);
        $roles = $this->role->getLists();

        return view('packages/core::roles.index', compact('roles'));
    }

    public function create(): View
    {
        $this->authorize('create', Role::class);
        $permissions = $this->permission->getLists();

        return view('packages/core::roles.form', compact('permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('edit', Role::class);
        $role = $this->role->getById($id)->load('permissions');
        $permissions = $this->permission->getLists();

        return view('packages/core::roles.form', compact('role', 'permissions'));
    }


    /**
     * @param RoleRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws ServerErrorException
     */
    public function update(RoleRequest $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->role->createOrUpdateRole($id, $request->all());
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
            $this->authorize('delete', Role::class);
            $this->role->deleteRole($id);
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
            $this->role->deleteAllById($ids);
            DB::commit();

            return responseSuccess(null, trans('packages/core::messages.delete_success'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__]);
            throw new ServerErrorException(null, trans('packages/core::messages.action_error'));
        }
    }
}
