@extends('components.layouts.app')

@section('content')
<h1>Generate Payroll</h1>

{{-- Display success or error messages --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if($employees->isEmpty())
    <p>No employees available.</p>
@else
<form action="{{ route('payrolls.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="employee_id">Employee</label>
        <label for="employee_id">Employee</label>
        <select id="employee_id" name="employee_id" required>
        @foreach ($employees as $employee)
            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
        @endforeach
        </select><br><br>
    </div>

    <div class="form-group">
        <label for="pay_period_start">Period Start</label>
        <input type="date" name="pay_period_start" id="pay_period_start" value="{{ old('pay_period_start') }}" required>
    </div>

    <div class="form-group">
        <label for="pay_period_end">Period End</label>
        <input type="date" name="pay_period_end" id="pay_period_end" value="{{ old('pay_period_end') }}" required>
    </div>

    <button type="submit">Generate Payroll</button>
</form>
@endif
@endsection
