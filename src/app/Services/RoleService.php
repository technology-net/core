<?php

namespace IBoot\Core\App\Services;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class RoleService
{
    /**
     * @return Collection|array
     */
    public function getLists(): Collection|array
    {
        return Role::query()->orderBy('created_at', 'desc')->get();
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
    public function createOrUpdateRoles($id, array $inputs = array()): Model|Builder
    {
        return Role::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRoles($id): mixed
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
