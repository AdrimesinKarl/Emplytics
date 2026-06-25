@extends('components.layouts.app')

@section('title', 'Attendance Details')

@section('content')
@php $prefix = auth()->user()->role . '.'; @endphp

<div class="container">
    <div class="header-section">
        <h1>Attendance Details</h1>
        <x-button href="{{ route($prefix . 'attendances.index') }}">Back to List</x-button>
    </div>

    <div class="details-card">
        <h2>{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</h2>
        <p><strong>Date:</strong> {{ $attendance->date->format('M d, Y') }}</p>
        <p><strong>Check In:</strong> {{ $attendance->check_in ? $attendance->check_in->format('h:i A') : '--' }}</p>
        <p><strong>Check Out:</strong> {{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '--' }}</p>
        <p><strong>Hours Worked:</strong> {{ number_format($attendance->hours_worked, 2) }} hrs</p>
    </div>

    //this section will check if user is authorized to edit or delete the attendance record
    @can('update', $attendance)
        <x-button href="{{ route($prefix . 'attendances.edit', $attendance) }}">Edit</x-button>
    @endcan

    @can('delete', $attendance)
        <form action="{{ route($prefix . 'attendances.destroy', $attendance) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Delete this record?')">Delete</button>
        </form>
    @endcan
</div>

@endsection