<?php
// app/Policies/SliderPolicy.php
namespace App\Policies;

use App\Models\Slider;
use App\Models\User;

class SliderPolicy
{
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Slider $slider)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Slider $slider)
    {
        return $user->role === 'admin';
    }
}
