@extends('components.layouts.app')

@section('title', 'Employee List')

@section('content')
    <div class="header-section">
        <h1>Employee List</h1>
        <x-button href="{{ route('employees.create') }}">Add New Employee</x-button>
    </div>

    {{-- Search and Filter Section --}}
    <div class="search-bar">
        <form action="{{ route('employees.index') }}" method="GET">
            <input type="text"
                name="search"
                placeholder="Search name or position..."
                value="{{ request('search') }}">
            <x-button type="submit">Search</x-button>
            
            @if(request('search'))
                <a href="{{ route('employees.index') }}" class="btn-link">Clear</a>
            @endif
        </form>
    </div>

    {{-- Data Display --}}
    @if ($employees->isNotEmpty())
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Hourly Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->first_name }}</td>
                            <td>{{ $employee->last_name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>${{ number_format($employee->hourly_rate, 2) }}</td>
                            <td>
                                <div class="action-buttons">
                                    {{-- Edit Link --}}
                                    <x-button href="{{ route('employees.edit', $employee) }}" type="secondary">
                                        Edit
                                    </x-button>

                                    {{-- Delete Form --}}
                                    <form method="POST"
                                        action="{{ route('employees.destroy', $employee) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this employee?')"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" class="btn-danger">Delete</x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>No employees found matching your criteria.</p>
        </div>
    @endif
@endsection