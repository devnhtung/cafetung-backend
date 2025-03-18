<?php
// app/Policies/PostPolicy.php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user)
    {
        return $user->role === 'staff';
    }

    public function update(User $user, Post $post)
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Post $post)
    {
        return $user->role === 'staff';
    }
}
