<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function createRestaurant(User $user): bool
    {
        return $user->has_restaurant === 0;
    }
}
