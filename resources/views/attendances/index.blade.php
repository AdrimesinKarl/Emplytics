@extends('components.layouts.app')

@section('title', 'Attendance List')

@section('content')

    <div class="header-section">
        <h1>Attendance List</h1>
        @can('create', App\Models\Attendance::class)
        <x-button href="{{ route('attendances.create') }}">Record New Attendance</x-button>
        @endcan
    </div>

    {{-- Filter Section --}}
    <div class="filter-card">
        <form action="{{ route('attendances.index') }}" method="GET">
            <label for="date">Filter by Date:</label>
            <input type="date" id="date" name="date" value="{{ request('date') }}">
            <x-button type="submit" type="secondary">Apply Filter</x-button>
            @if(request('date'))
                <a href="{{ route('attendances.index') }}" class="btn-link">Clear Filter</a>
            @endif
        </form>
    </div>

    {{-- Data Display --}}
    @if ($attendances->isNotEmpty())
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Hours Worked</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            {{-- Accessing the related employee model --}}
                            <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                            
                            {{-- Formatting dates and times via Carbon --}}
                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                            <td>{{ $attendance->check_in ? $attendance->check_in->format('h:i A') : '--' }}</td>
                            <td>{{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '--' }}</td>
                            
                            {{-- Using the accessor we built in the Model --}}
                            <td><strong>{{ number_format($attendance->hours_worked, 2) }} hrs</strong></td>
                            
                            <td>
                                <a href="{{ route('attendances.edit', $attendance) }}">Edit</a>
                                {{-- Simple Delete Form --}}
                                <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>No attendance records found for the selected criteria.</p>
        </div>
    @endif
@endsection