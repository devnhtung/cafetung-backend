<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function create(User $user)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }

    public function update(User $user, Product $product)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'manage' || $user->role === 'admin';
    }
}
