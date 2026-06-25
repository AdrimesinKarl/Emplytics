<?php
    namespace App\Policies;

    use App\Models\User;
    use App\Models\Attendance;

    class AttendancePolicy
    {
        public function before(User $user, $ability): bool|null
        {
            if (strtolower($user->role) === 'admin') {
                return true; // Admins can do everything, skip all other checks
            }
            return null; // fall through to individual policy methods for other roles
        }
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
        public function view(User $user, Attendance $attendance): bool
        {
        return in_array($user->role, ['admin', 'hr'])
            || $user->id === $attendance->employee_id;
        }
        
        public function update(User $user, Attendance $attendance): bool
        {
            return in_array($user->role, ['admin', 'hr']);
        }

        public function delete(User $user, Attendance $attendance): bool
        {
            return in_array($user->role, ['admin', 'hr']);
        }

    }


