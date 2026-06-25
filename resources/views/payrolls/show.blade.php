@extends ('components.layouts.app')

@section ('title','Payroll Details')

@section('content')


@php $prefix = auth()->user()->role . '.'; @endphp

    <div class="container">
        <h1>Payroll Details</h1>
        
        <form action="{{ route($prefix . 'payrolls.store') }}" method="POST"></form>
    <div class="header-section">
        <h1>Payroll Details</h1>
        <x-button href="{{$prefix . route('payrolls.index') }}">Back to List</x-button>
    </div>

    <div class="details-card">
        <h2>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</h2>
        <p><strong>Date:</strong> {{ $payroll->date->format('M d, Y') }}</p>
        <p><strong>Check In:</strong> {{ $payroll->check_in ? $payroll->check_in->format('h:i A') : '--' }}</p>
        <p><strong>Check Out:</strong> {{ $payroll->check_out ? $payroll->check_out->format('h:i A') : '--' }}</p>
        <p><strong>Hours Worked:</strong> {{ number_format($payroll->hours_worked, 2) }} hrs</p>
    </div>

@endsection