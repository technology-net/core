<?php

namespace IBoot\Core\App\Policies;

use IBoot\Core\App\Models\User;

class RolePolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
	    return $user->hasPermissionTo('view roles');
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
	    return $user->hasPermissionTo('create roles');
	}

	/**
	 * Determine whether the user can edit the model.
	 */
	public function edit(User $user): bool
	{
	    return $user->hasPermissionTo('edit roles');
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user): bool
	{
	    return $user->hasPermissionTo('delete roles');
	}
}
