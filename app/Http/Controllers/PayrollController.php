<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Display a listing of payrolls
     */
    public function index()
    {
        $payrolls = Payroll::with('employee')->get();
        return view('payrolls.index', compact('payrolls'));
    }
    /**
     * Show the form to generate payroll
     */
    public function create()
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }
    /**
     * Store a newly generated payroll
     */
public function store(Request $request)
{
    $employeeId = $request->employee_id;
    $start = $request->pay_period_start;
    $end = $request->pay_period_end;

    //check if payroll already exists for this employee and period
    $exists = Payroll::where('employee_id', $employeeId)
    ->where('pay_period_start', $start)
    ->where('pay_period_end', $end)
    ->exists();

    if ($exists) {
    return redirect()->back()->with('error', 'Payroll already exists for this period.');
}

    $employee = Employee::findOrFail($employeeId);

    // Calculate total hours from attendance
    $attendances = Attendance::where('employee_id', $employeeId)
        ->whereBetween('date', [$start, $end])
        ->get();

    $totalHours = 0;

    foreach ($attendances as $attendance) {
        if ($attendance->check_in && $attendance->check_out) {
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = Carbon::parse($attendance->check_out);

            $totalHours += $checkOut->diffInMinutes($checkIn) / 60;
        }
    }

    // Calculate gross pay, deductions, net pay
    $grossPay = $totalHours * $employee->hourly_rate;
    $deductions = 0;
    $netPay = $grossPay - $deductions;

    // Save payroll
    Payroll::create([
        'employee_id' => $employeeId,
        'pay_period_start' => $start,
        'pay_period_end' => $end,

        // automatically calculated
        'total_hours' => round($totalHours, 2),
        'gross_pay' => round($grossPay, 2),
        'deductions' => round($deductions, 2),
        'net_pay' => round($netPay, 2),
        'generated_at' => now(),
    ]);

    return redirect()->route('payrolls.index')
        ->with('success', 'Payroll generated successfully');

}


        /**
         * Display the specified resource.
         */
        public function show(Payroll $payroll)
        {
            //
        }
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Payroll $payroll)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Payroll $payroll)
        {
            //
        }
        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Payroll $payroll)
        {
            //
        }
}
