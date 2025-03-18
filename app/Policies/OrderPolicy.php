<?php
// app/Policies/OrderPolicy.php
namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order)
    {
        return $user->role === 'staff' || $user->id === $order->user_id;
    }

    public function update(User $user, Order $order)
    {
        return $user->role === 'staff';
    }

    public function delete(User $user, Order $order)
    {
        return $user->role === 'staff';
    }
}
