<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DashboardController;
Route::view('/', 'welcome');

// routes/web.php

// Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

// Admin + HR
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payrolls', PayrollController::class);
});

// Employee only
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.mine');
    Route::get('my-payroll', [PayrollController::class, 'myPayroll'])->name('payroll.mine');
});

// All authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/check-role', function () {
    return [
        'name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'role' => auth()->user()->role,
    ];
    });

require __DIR__.'/auth.php';
