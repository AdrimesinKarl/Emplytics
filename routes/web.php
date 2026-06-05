<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payrolls', PayrollController::class);
});

Route::middleware(['auth', 'role:hr'])->prefix('hr')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('payrolls', PayrollController::class);
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/my-attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/my-attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
});

require __DIR__.'/auth.php';
