@extends('components.layouts.app')

@section('title', 'Payroll Records')

@section('content')

@php $prefix = auth()->user()->role . '.'; @endphp

    <div class="header-section">
        <h1>Payroll List</h1>
        @can('create', App\Models\Payroll::class)
            <x-button href="{{ route($prefix . 'payrolls.create') }}">Generate New Payroll</x-button>
        @endcan
    </div>

    {{-- Success Message Display --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($payrolls->isNotEmpty())
        <div class="table-container">
            <table border="1" cellpadding="5">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Pay Period</th>
                        <th>Total Hours</th>
                        <th>Net Pay</th>
                        <th>Status / Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                        <tr>
                            {{-- Employee relationship access --}}
                            <td>
                                <strong>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</strong>
                            </td>

                            {{-- Formatted Date Range --}}
                            <td>
                                {{ $payroll->pay_period_start->format('M d') }} -
                                {{ $payroll->pay_period_end->format('M d, Y') }}
                            </td>

                            {{-- Hours worked --}}
                            <td>{{ number_format($payroll->total_hours, 2) }} hrs</td>

                            {{-- Financials --}}
                            <td>${{ number_format($payroll->net_pay, 2) }}</td>

                            {{-- Action column fixed inside the <tr> --}}
                            <td>
                                <div class="action-group" style="display: flex; gap: 5px;">
                                    @can('update', $payroll)
                                    <x-button href="{{ route($prefix . 'payrolls.edit', $payroll) }}" type="secondary">
                                        Edit
                                    </x-button>
                                    @endcan

                                    <form method="POST"
                                        action="{{ route($prefix . 'payrolls.destroy', $payroll) }}"
                                        onsubmit="return confirm('Delete this record permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        @can('delete', $payroll)
                                        <x-button type="submit" class="btn-danger">Delete</x-button>
                                        @endcan
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
            @can('create', App\Models\Payroll::class)
                <p>No payroll records found. <a href="{{ route($prefix . 'payrolls.create') }}">Generate the first one here.</a></p>
            @endcan
        </div>
    @endif
@endsection