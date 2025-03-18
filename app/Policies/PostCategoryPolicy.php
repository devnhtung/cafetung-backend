<?php

namespace App\Policies;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostCategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->role === 'staff';
    }

    public function update(User $user, PostCategory $category): bool
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, PostCategory $category): bool
    {
        return $user->role === 'staff';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PostCategory $postCategory): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PostCategory $postCategory): bool
    {
        return false;
    }
}
