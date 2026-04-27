<?php

namespace App\Policies;

use App\Models\User;
use Symfony\Component\CssSelector\Node\AttributeNode;

class AttendancePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'hr', 'employee']);
    }

    public function view(User $user, Attendance $attendance)
    {
        return $user->role === 'admin'
        || $user->role === 'hr'
        || $user->id === $attendance->employee_id;
    }
}


