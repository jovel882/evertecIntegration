<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user)
    {
        return $user->can('orders.viewAny');
    }

    /**
     * Determine whether the user can work the order.
     */
    public function workThis(User $user, Order $order)
    {
        return $this->viewAny($user) || $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order)
    {
        return $this->workThis($user, $order);
    }

    /**
     * Determine whether the user can create orders.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determina si el usuario puede pagar la orden.
     *
     * @param \App\Models\User $user Usuario.
     * @param \App\Models\Order $order Orden.
     */
    public function pay(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine whether the user can update the order.
     */
    public function update(User $user, Order $order)
    {
        return $user->can('orders.update') && $this->workThis($user, $order);
    }

    /**
     * Determine whether the user can delete the order.
     */
    public function delete(User $user, Order $order)
    {
        return $user->can('orders.delete') && $this->workThis($user, $order);
    }

    /**
     * Determine whether the user can restore the order.
     */
    public function restore(User $user, Order $order)
    {
        return $user->can('orders.restore') && $this->workThis($user, $order);
    }

    /**
     * Determine whether the user can permanently delete the order.
     */
    public function forceDelete(User $user, Order $order)
    {
        return $user->can('orders.forceDelete') && $this->workThis($user, $order);
    }

    public function trash(User $user)
    {
        return $user->can('orders.trash');
    }
}
