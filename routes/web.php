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

Route::resource('employees',EmployeeController::class)->middleware('auth'); //this is the route to list all employees

Route::resource('attendances', AttendanceController::class)->middleware('auth'); //this is the route to list all attendances

Route::resource('payrolls', PayrollController::class)->middleware('can:access-payroll'); //this is the route to list all payrolls

require __DIR__.'/auth.php';
