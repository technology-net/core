<?php

namespace IBoot\Core\App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class RoleService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Role::query()
                ->with('permissions')
                ->orderBy('created_at', 'desc')
                ->get();
    }

    /**
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    public function getById(int $id): Model|Collection|Builder|array|null
    {
        return $this->findById($id);
    }


    /**
     * @param $id
     * @param array $inputs
     * @return Model|Builder
     */
    public function createOrUpdateRole($id, array $inputs = array()): Model|Builder
    {
        $permissions = Arr::get($inputs, 'permissions', []);
        if (!empty($inputs['permission_selected'])) {
            $permissionSelected = json_decode($inputs['permission_selected'], true);
        }
        unset($inputs['permissions'], $inputs['permission_selected']);

        $role = Role::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );

        // delete permissions
        if (count($permissionSelected)) {
            $role->revokePermissionTo($permissionSelected);
        }
        // permission assigned to a role
        if (count($permissions)) {
            $role->givePermissionTo($permissions);
        }

        return $role;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRole($id): mixed
    {
        return Role::query()->where('id', $id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return Role::query()->whereIn('id', $ids)->delete();
    }

    /**
     * @param $id
     * @return Model|Collection|Builder|array|null
     */
    private function findById($id): Model|Collection|Builder|array|null
    {
        return Role::query()->findOrFail($id);
    }
}
