<?php
// app/Policies/SliderPolicy.php
namespace App\Policies;

use App\Models\Slider;
use App\Models\User;

class SliderPolicy
{
    public function create(User $user)
    {
        return $user->role === 'staff';
    }

    public function update(User $user, Slider $slider)
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Slider $slider)
    {
        return $user->role === 'staff';
    }
}
