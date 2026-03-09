<?php

namespace App\Policies;

use App\Models\User;

class PayrollPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user): bool

    //This where logic lives for security and authorization. We can check the user role and return true or false based on that.
    {
        return match ($user->role) {
            UserRole::Admin, UserRole::HR => true,
            default => false,
        };
    }
}
