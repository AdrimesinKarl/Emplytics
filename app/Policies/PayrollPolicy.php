<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payroll;

class PayrollPolicy
{
    /**
         * Create a new policy instance.
         */
        public function create(User $user): bool
        {
            return in_array($user->role, ['admin', 'hr']);
        }
        public function viewAny(User $user)
        {
            return in_array($user->role, ['admin', 'hr', 'employee']);
        }
        public function view(User $user, Payroll $payroll): bool
        {
            return in_array($user->role, ['admin', 'hr'])
                || $user->id === $payroll->employee_id;
        }

        public function update(User $user, Payroll $payroll): bool
        {
            return in_array($user->role, ['admin', 'hr']);
        }

        public function delete(User $user, Payroll $payroll): bool
        {
            return in_array($user->role, ['admin', 'hr']);
        }
}
