<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">EMS</a>

        <ul class="navbar-nav ms-auto">

@auth
    {{-- Visible to all --}}
    <a href="{{ route('dashboard') }}">Dashboard</a>

    {{-- Admin + HR only --}}
    @if(in_array(auth()->user()->role, ['admin', 'hr']))
        <a href="{{ route('employees.index') }}">Employees</a>
        <a href="{{ route('attendances.index') }}">Attendance</a>
        <a href="{{ route('payrolls.index') }}">Payroll</a>
    @endif

    {{-- Admin only --}}
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('users.index') }}">Users</a>
    @endif

    {{-- Employee only --}}
    @if(auth()->user()->role === 'employee')
        <a href="{{ route('attendance.mine') }}">My Attendance</a>
        <a href="{{ route('payroll.mine') }}">My Payroll</a>
    @endif

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endauth
        </ul>
    </div>
</nav>