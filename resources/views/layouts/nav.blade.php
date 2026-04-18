<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">EMS</a>

        <ul class="navbar-nav ms-auto">

            @auth
                <!-- Admin -->
                @if(auth()->user()->role === 'admin')
                    <li class="nav-item"><a class="nav-link" href="/employees">Employees</a></li>
                    <li class="nav-item"><a class="nav-link" href="/attendances">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="/payrolls">Payroll</a></li>
                @endif

                <!-- HR -->
                @if(auth()->user()->role === 'hr')
                    <li class="nav-item"><a class="nav-link" href="/employees">Employees</a></li>
                    <li class="nav-item"><a class="nav-link" href="/attendances">Attendance</a></li>
                @endif

                <!-- Employee -->
                @if(auth()->user()->role === 'employee')
                    <li class="nav-item"><a class="nav-link" href="/my-attendance">My Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="/my-payroll">My Payroll</a></li>
                @endif

                <!-- Logout -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
            @endauth

        </ul>
    </div>
</nav>