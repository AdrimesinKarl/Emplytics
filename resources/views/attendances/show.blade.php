@extends ('components.layouts.app')

@section ('title','Attendance Details')

@section('content')

    <div class="header-section">
        <h1>Attendance Details</h1>
        <x-button href="{{ route('attendances.index') }}">Back to List</x-button>
    </div>

    <div class="details-card">
        <h2>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</h2>
        <p><strong>Date:</strong> {{ $attendance->date->format('M d, Y') }}</p>
        <p><strong>Check In:</strong> {{ $attendance->check_in ? $attendance->check_in->format('h:i A') : '--' }}</p>
        <p><strong>Check Out:</strong> {{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '--' }}</p>
        <p><strong>Hours Worked:</strong> {{ number_format($attendance->hours_worked, 2) }} hrs</p>
    </div>

@endsection