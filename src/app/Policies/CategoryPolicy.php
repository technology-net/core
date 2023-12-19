<?php

namespace IBoot\Core\App\Policies;

use IBoot\Core\App\Models\User;

class CategoryPolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
	    return $user->hasPermissionTo('view categories');
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
	    return $user->hasPermissionTo('create categories');
	}

	/**
	 * Determine whether the user can edit the model.
	 */
	public function edit(User $user): bool
	{
	    return $user->hasPermissionTo('edit categories');
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user): bool
	{
	    return $user->hasPermissionTo('delete categories');
	}
}
