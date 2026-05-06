<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Attendance;

class DashboardController extends Controller
{

    // app/Http/Controllers/DashboardController.php
public function index(): View
{
    $user = auth()->user();

    return match($user->role) {
        'admin' => view('dashboard.admin', [
            'totalEmployees' => Employee::count(),
            'totalPayroll'   => Payroll::sum('net_salary'),
            'totalAttendances' => Attendance::count(),
        ]),
        'hr' => view('dashboard.hr', [
            'totalEmployees'   => Employee::count(),
            'totalAttendances' => Attendance::count(),
        ]),
        'employee' => view('dashboard.employee', [
            'attendances' => $user->employee->attendances()->latest()->take(5)->get(),
            'payrolls'    => $user->employee->payrolls()->latest()->take(5)->get(),
        ]),
        default => abort(403),
    };
}

}
