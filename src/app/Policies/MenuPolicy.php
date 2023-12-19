<?php

namespace IBoot\Core\App\Policies;

use IBoot\Core\App\Models\User;

class MenuPolicy
{
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny(User $user): bool
	{
	    return $user->hasPermissionTo('view menus');
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create(User $user): bool
	{
	    return $user->hasPermissionTo('create menus');
	}

	/**
	 * Determine whether the user can edit the model.
	 */
	public function edit(User $user): bool
	{
	    return $user->hasPermissionTo('edit menus');
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete(User $user): bool
	{
	    return $user->hasPermissionTo('delete menus');
	}
}
