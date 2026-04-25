<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/payrolls', PayrollController::class);
});

Route::middleware(['auth', 'role:admin, hr'])->group(function () {
    Route::resource('/employees', EmployeeController::class);
    Route::resource('/attendances', AttendanceController::class);
});

Route::middleware(['auth', 'role:employee'])->group(function() {
    Route::get('/attendances', [AttendanceController::class, 'index'])
    ->name('attendances.index');
    Route::get('/payrolls', [PayrollController::class, 'index'])
    ->name('payrolls.index');
});

Route::get('/check-role', function () {
    return [
        'name' => auth()->user()->name,
        'email' => auth()->user()->email,
        'role' => auth()->user()->role,
    ];
});

require __DIR__.'/auth.php';
