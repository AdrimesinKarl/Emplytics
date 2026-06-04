@extends('components.layouts.app')

@section('content')
    <div class="container">
        <h1>Record Attendance</h1>
        
        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf

            {{-- Employee Selection --}}
            <div class="form-group">
                <label for="employee_id">Employee</label>
                <select id="employee_id" name="employee_id" required>
                    <option value="" disabled {{ old('employee_id') ? '' : 'selected' }}>Select an Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            {{-- Attendance Date --}}
            <div class="form-group">
                <label for="attendance_date">Date</label>
                <input type="date" id="attendance_date" name="attendance_date" value="{{ old('attendance_date', date('Y-m-d')) }}" required>
                @error('date') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            {{-- Time Logs --}}
            <div class="form-group">
                <label for="check_in">Check In</label>
                <input type="time" id="check_in" name="check_in" value="{{ old('check_in') }}">
                @error('check_in') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="check_out">Check Out</label>
                <input type="time" id="check_out" name="check_out" value="{{ old('check_out') }}">
                @error('check_out') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            {{-- Submission Actions --}}
            <div class="form-actions">
                <x-button type="submit">Record Attendance</x-button>
                <x-button href="{{ route('attendances.index') }}" type="secondary">Cancel</x-button>
            </div>
        </form>

        {{-- Global Error List (Optional if using inline errors above) --}}
        @if ($errors->any())
            <div class="alert alert-danger mt-4">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection