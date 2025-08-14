<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }

    public function update(User $user)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }

    public function delete(User $user)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }
}