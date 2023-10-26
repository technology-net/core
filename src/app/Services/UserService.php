<?php

namespace IBoot\Core\App\Services;

use IBoot\Core\App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get user list
     *
     * @return LengthAwarePaginator
     */
    public function getUsers(): LengthAwarePaginator
    {
        return User::query()->orderBy('created_at', 'desc')
            ->paginate(config('core.pagination'));
    }

    /**
     * Create a new user
     *
     * @param array $input
     * @return Model
     */
    public function newUser(array $input = []): Model
    {
        $input['password'] = Hash::make('password');
        $input['status'] = User::STATUS_ACTIVATED;

        return User::query()->create($input);
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
     * Update a user
     *
     * @param int $id
     * @param array $input
     * @return mixed
     */
    public function updateUser(int $id, array $input = []): mixed
    {
        return $this->findUserById($id)->update($input);
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
