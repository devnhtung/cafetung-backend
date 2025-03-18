<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function create(User $user)
    {
        return $user->role === 'staff';
    }

    public function update(User $user, Product $product)
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Product $product)
    {
        return $user->role === 'staff';
    }
}
