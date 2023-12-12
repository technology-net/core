<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @return Collection|array
     */
    public function getUsers(): Collection|array
    {
        return User::query()
                ->with('roles')
                ->where('level', '>=', Auth::user()->level)
                ->orderBy('created_at', 'desc')
                ->get();
    }

    /**
     * Show a user
     *
     * @param int $id
     * @return array|Builder|Collection|Model
     */
    public function showUser(int $id): array|Builder|Collection|Model
    {
        return $this->findUserById($id);
    }

    /**
     * @param $id
     * @param array $inputs
     * @return Model|Builder
     */
    public function createOrUpdateUser($id, array $inputs = array()): Model|Builder
    {
        $inputs['password'] = Hash::make(config('core.password_default'));
        $roles = Arr::get($inputs, 'roles', []);
        if (!empty($inputs['role_selected'])) {
            $roleSelected = json_decode($inputs['role_selected'], true);
        }
        unset($inputs['roles'], $inputs['role_selected']);

        $user = User::query()->updateOrCreate(
            ['id' => $id],
            $inputs
        );

        // delete role
        if (count($roleSelected)) {
            foreach ($roleSelected as $role) {
                $user->removeRole($role);
            }
        }

        // role assigned to a $user
        if (count($roles)) {
            $user->assignRole($roles);
        }

        return $user;
    }

    /**
     * Delete a user
     *
     * @param int $id
     * @return mixed
     */
    public function deleteUser(int $id): mixed
    {
        return $this->findUserById($id)->delete();
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function deleteAllById($ids): mixed
    {
        return User::query()->whereIn('id', $ids)->delete();
    }

    /**
     * Find a user by id
     *
     * @param int $id
     * @return Model|Collection|Builder|array|null
     */
    private function findUserById(int $id): Model|Collection|Builder|array|null
    {
        return User::query()->findOrFail($id);
    }
}
