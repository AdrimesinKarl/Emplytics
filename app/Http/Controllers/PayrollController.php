<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

/**
 * Manages the generation and lifecycle of employee payroll records.
 * * This controller handles calculating hours from attendance logs,
 * computing gross/net pay based on employee rates, and record management.
 */
class PayrollController extends Controller
{
    /**
     * Display a listing of all generated payrolls.
     * Uses Eager Loading ('with') to prevent N+1 query issues.
     *
     * @return View
     */
    public function index()
    {
    $user = auth()->user();

    $payrolls = $user->role === 'employee'
        ? Payroll::where('employee_id', $user->id)->latest()->get()
        : Payroll::latest()->get();

    return view('payrolls.index', compact('payrolls'));
    }
    public function create(): View
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }
    /**
     * Store a newly generated payroll in the database.
     * * Logic:
     * 1. Validates the period.
     * 2. Checks for existing payroll to prevent duplicates.
     * 3. Aggregates attendance minutes and converts to hours.
     * 4. Multiplies hours by the employee's hourly rate.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id'      => ['required', 'exists:employees,id'],
            'pay_period_start' => ['required', 'date'],
            'pay_period_end'   => ['required', 'date', 'after_or_equal:pay_period_start'],
        ]);

        // Prevent duplicate payroll records for the same employee and period
        $exists = Payroll::where('employee_id', $validated['employee_id'])
            ->where('pay_period_start', $validated['pay_period_start'])
            ->where('pay_period_end', $validated['pay_period_end'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Payroll already exists for this period.');
        }

        $employee = Employee::findOrFail($validated['employee_id']);

        // Fetch all attendance logs within the date range
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$validated['pay_period_start'], $validated['pay_period_end']])
            ->get();

        $totalHours = 0;
        foreach ($attendances as $attendance) {
            if ($attendance->check_in && $attendance->check_out) {
                $checkIn = Carbon::parse($attendance->check_in);
                $checkOut = Carbon::parse($attendance->check_out);
                
                // Calculate difference in minutes and convert to decimal hours
                $totalHours += $checkOut->diffInMinutes($checkIn) / 60;
            }
        }

        // Financial Calculations
        $grossPay = $totalHours * $employee->hourly_rate;
        $deductions = 0; // Placeholder for future tax/benefits logic
        $netPay = $grossPay - $deductions;

        Payroll::create([
            ...$validated,
            'total_hours'  => round($totalHours, 2),
            'gross_pay'    => round($grossPay, 2),
            'deductions'   => round($deductions, 2),
            'net_pay'      => round($netPay, 2),
            'generated_at' => now(),
        ]);

        return to_route('payrolls.index')->with('success', 'Payroll generated successfully');
    }
    /**
     * Show the form for editing an existing payroll record.
     *
     * @param Payroll $payroll
     * @return View
     */
    public function edit(Payroll $payroll): View
    {
        $employees = Employee::all();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the payroll record details.
     *
     * @param Request $request
     * @param Payroll $payroll
     * @return RedirectResponse
     */
    public function update(Request $request, Payroll $payroll): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id'      => ['required', 'exists:employees,id'],
            'pay_period_start' => ['required', 'date'],
            'pay_period_end'   => ['required', 'date', 'after_or_equal:pay_period_start'],
            'total_hours'      => ['required', 'numeric', 'min:0'],
            'net_pay'          => ['required', 'numeric', 'min:0'],
        ]);

        $payroll->update($validated);

        return to_route('payrolls.index')->with('success', 'Payroll updated successfully');
    }

    /**
     * Remove the payroll record from storage.
     *
     * @param Payroll $payroll
     * @return RedirectResponse
     */
    public function destroy(Payroll $payroll): RedirectResponse
    {
        $payroll->delete();
        return to_route('payrolls.index')->with('success', 'Payroll deleted successfully!');
    }
}