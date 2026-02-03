@extends('components.layouts.app')

@section('content')
<h1>Payroll List</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($payrolls->isEmpty())
    <p>No payroll records found.</p>
@else
<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Period</th>
        <th>Total Hours</th>
        <th>Net Pay</th>
    </tr>

    @foreach($payrolls as $payroll)
        <tr>
            <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
            <td>{{ $payroll->pay_period_start }} - {{ $payroll->pay_period_end }}</td>
            <td>{{ number_format($payroll->total_hours, 2) }}</td>
            <td>{{ number_format($payroll->net_pay, 2) }}</td>
        </tr>
    @endforeach
</table>
@endif
@endsection
