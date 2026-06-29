@extends('components.layouts.app')

@section('title', 'Attendance List')

@section('content')
@php $prefix = auth()->user()->role . '.'; @endphp

<div class="container">
    <div class="header-section">
        <h1>Attendance List</h1>
        @can('create' , App\Models\Attendance::class)
            <x-button href="{{ route($prefix . 'attendances.create') }}">Record New Attendance</x-button>
        @endcan
    </div>

    {{-- Filter Section --}}
    <div class="filter-card">
        <form action="{{ route($prefix . 'attendances.index') }}" method="GET">
            <label for="date">Filter by Date:</label>
            <input type="date" id="date" name="date" value="{{ request('date') }}">
            <x-button type="submit" variant="secondary">Apply Filter</x-button>
            @if(request('date'))
                <x-button href="{{ route($prefix . 'attendances.index') }}" class="btn-link">Clear Filter</x-button>
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
                            <td>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</td>
                            <td>{{ $attendance->date?->format('M d, Y') }}</td>
                            <td>{{ $attendance->check_in ? $attendance->check_in->format('h:i A') : '--' }}</td>
                            <td>{{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '--' }}</td>
                            <td><strong>{{ number_format($attendance->hours_worked, 2) }} hrs</strong></td>
                                <td>
                                    @can('update', $attendance)
                                        <x-button href="{{ route($prefix . 'attendances.edit', $attendance) }}">Edit</x-button>
                                    @endcan
                                    @can('delete', $attendance)
                                        <form action="{{ route($prefix . 'attendances.destroy', $attendance) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" onclick="return confirm('Delete this record?')">Delete</x-button>
                                        </form>
                                    @endcan
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
</div>

@endsection