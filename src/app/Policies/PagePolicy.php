<?php

namespace IBoot\Core\App\Policies;

use IBoot\Core\App\Models\User;

class PagePolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
	    return $user->hasPermissionTo('view pages');
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
	    return $user->hasPermissionTo('create pages');
	}

	/**
	 * Determine whether the user can edit the model.
	 */
	public function edit(User $user): bool
	{
	    return $user->hasPermissionTo('edit pages');
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user): bool
	{
	    return $user->hasPermissionTo('delete pages');
	}
}
