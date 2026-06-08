@php $prefix = auth()->user()->role . '.'; @endphp

<h1>Edit Payroll</h1>

<div class="container">
    <form action="{{ route($prefix . 'payrolls.update', $payroll->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Employee Selection --}}
        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select id="employee_id" name="employee_id" required>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" 
                        {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Pay Period Start --}}
        <div class="form-group">
            <label for="pay_period_start">Pay Period Start</label>
            <input type="date"
                    id="pay_period_start"
                    name="pay_period_start"
                    value="{{ old('pay_period_start', $payroll->pay_period_start->format('Y-m-d')) }}"
                    required>
            @error('pay_period_start') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Pay Period End --}}
        <div class="form-group">
            <label for="pay_period_end">Pay Period End</label>
            <input type="date"
                    id="pay_period_end"
                    name="pay_period_end"
                    value="{{ old('pay_period_end', $payroll->pay_period_end->format('Y-m-d')) }}"
                    required>
            @error('pay_period_end') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Total Hours --}}
        <div class="form-group">
            <label for="total_hours">Total Hours</label>
            <input type="number"
                    id="total_hours"
                    name="total_hours"
                    step="0.01"
                    min="0"
                    value="{{ old('total_hours', $payroll->total_hours) }}"
                    required>
        </div>

        {{-- Net Pay --}}
        <div class="form-group">
            <label for="net_pay">Net Pay</label>
            <input type="number"
                    id="net_pay"
                    name="net_pay"
                    step="0.01"
                    min="0"
                    value="{{ old('net_pay', $payroll->net_pay) }}"
                    required>
        </div>

        <div class="actions">
            <x-button type="success">Update Payroll</x-button>
            <x-button href="{{ route($prefix . 'payrolls.index') }}" type="secondary">Back</x-button>
        </div>
    </form>
</div>