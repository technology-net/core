<?php

namespace IBoot\Core\App\Services;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PermissionService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Permission::query()
                ->with('roles')
                ->orderBy('id', 'desc')
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
    public function createOrUpdatePermission($id, array $inputs = array()): Model|Builder
    {
        $roles = Arr::get($inputs, 'roles', []);

        if (!empty($inputs['role_selected'])) {
            $roleSelected = json_decode($inputs['role_selected'], true);
        }
        unset($inputs['roles'], $inputs['role_selected']);

        $permission =  Permission::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );
        // delete role
        if (count($roleSelected)) {
            foreach ($roleSelected as $role) {
                $permission->removeRole($role);
            }
        }
        // permission assigned to a role
        if (count($roles)) {
            $permission->assignRole($roles);
        }

        return $permission;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deletePermission($id): mixed
    {
        return Permission::query()->where('id', $id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return Permission::query()->whereIn('id', $ids)->delete();
    }

    /**
     * @param $id
     * @return Model|Collection|Builder|array|null
     */
    private function findById($id): Model|Collection|Builder|array|null
    {
        return Permission::query()->findOrFail($id);
    }
}
