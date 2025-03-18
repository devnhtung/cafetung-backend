<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->role === 'staff';
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'staff';
    }
}
