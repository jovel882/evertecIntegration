<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function isNotAuth(?User $user)
    {
        return !isset($user);
    }

    public function isAuth(User $user)
    {
        return true;
    }
}
