<h1>Edit Payroll</h1>

<form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="employee_id">Employee</label>
    <select id="employee_id" name="employee_id" required>
        @foreach($employees as $emoployee)
            <option value="{{ $employee->id }}" {{ $payroll->employee_id == $employee->id ? 'selected' : '' }}>
                {{ $employee->first_name }} {{ $employee->last_name }}
            </option>
        @endforeach
    </select><br><br>

    <label for="pay_period_start">Pay Period Start</label>
    <input type="date" id="pay_period_start" name="pay_period_start" value="{{ $payroll->pay_period_start->format('Y-m-d') }}" required><br><br>

    <label for="pay_period_end">Pay Period End</label>
    <input type="date" id="pay_period_end" name="pay_period_end" value="{{ $payroll->pay_period_end->format('Y-m-d') }}" required><br><br>

    <label for="total_hours">Total Hours</label>
    <input type="number" id="total_hours" name="total_hours" step="0.01" min="0" value="{{ $payroll->total_hours }}" required><br><br>

    <label for="net_pay">Net Pay</label>
    <input type="number" id="net_pay" name="net_pay" step="0.01" min="0" value="{{ $payroll->net_pay }}" required><br><br>

    <x-button type="success">Submit</x-button>
    <x-button href="{{ route('payrolls.index') }}" type="secondary">Back</x-button>
</form>


