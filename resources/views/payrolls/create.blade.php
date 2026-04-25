@extends('components.layouts.app')

@section('title', 'Generate Payroll')

@section('content')
<div class="container">
    <h1>Generate Payroll</h1>

    {{-- Session Feedback --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($employees->isEmpty())
        <div class="empty-state">
            <p>No employees found. Please <a href="{{ route('employees.create') }}">add an employee</a> first.</p>
        </div>
    @else
        <form action="{{ route('payrolls.store') }}" method="POST" class="payroll-form">
            @csrf

            {{-- Employee Selection --}}
            <div class="form-group">
                <label for="employee_id">Select Employee</label>
                <select id="employee_id" name="employee_id" required>
                    <option value="" disabled {{ old('employee_id') ? '' : 'selected' }}>Choose an employee...</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->position }})
                        </option>
                    @endforeach
                </select>
                @error('employee_id') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            {{-- Date Range Selection --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="pay_period_start">Period Start</label>
                    <input type="date"
                        name="pay_period_start"
                        id="pay_period_start"
                        value="{{ old('pay_period_start') }}"
                        required>
                    @error('pay_period_start') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="pay_period_end">Period End</label>
                    <input type="date"
                        name="pay_period_end"
                        id="pay_period_end"
                        value="{{ old('pay_period_end') }}"
                        required>
                    @error('pay_period_end') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <x-button type="submit">Generate Payroll Record</x-button>
                <x-button href="{{ route('payrolls.index') }}" type="secondary">Cancel</x-button>
            </div>
        </form>
    @endif
</div>
@endsection