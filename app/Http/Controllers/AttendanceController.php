<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Handles the recording and management of employee daily attendance.
 * Tracks check-in/check-out times and links them to specific dates and employees.
 */
class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records.
     * Uses eager loading ('with') to fetch employee details in a single query.
     *
     * @return View
     */
    public function index(): View
    {
        // Eager load the employee relationship to optimize database performance
        $attendances = Attendance::with('employee')->latest('date')->get();
        $attendances = Attendance::where('user_id', auth()->id())->get();
        
        return view('attendances.index', compact('attendances'));
    }
    /**
     * Show the form for recording a new attendance entry.
     *
     * @return View
     */
    public function create(): View
    {
        // Fetch employees to populate the selection dropdown
        $employees = Employee::orderBy('last_name')->get();
        
        return view('attendances.create', compact('employees'));
    }

    /**
     * Store a newly created attendance record.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Array-based validation is preferred in modern Laravel
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date'        => ['required', 'date'],
            'check_in'    => ['nullable', 'date_format:H:i'],
            'check_out'   => ['nullable', 'date_format:H:i'],
        ]);

        Attendance::create($validated);

        return to_route('attendances.index')
            ->with('success', 'Attendance recorded successfully!');
    }
    /**
     * Show the form for editing a specific attendance record.
     *
     * @param Attendance $attendance (Route Model Binding)
     * @return View
     */
    public function edit(Attendance $attendance): View
    {
        $employees = Employee::orderBy('last_name')->get();
        
        return view('attendances.edit', compact('attendance', 'employees'));
    }
    /**
     * Update the specified attendance record.
     *
     * @param Request $request
     * @param Attendance $attendance
     * @return RedirectResponse
     */
    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date'        => ['required', 'date'],
            'check_in'    => ['nullable', 'date_format:H:i'],
            'check_out'   => ['nullable', 'date_format:H:i'],
        ]);

        $attendance->update($validated);

        return to_route('attendances.index')
            ->with('success', 'Attendance updated successfully!');
    }
    /**
     * Remove the attendance record from the database.
     *
     * @param Attendance $attendance
     * @return RedirectResponse
     */
    public function destroy(Attendance $attendance): RedirectResponse
    {
        $attendance->delete();

        return to_route('attendances.index')
            ->with('success', 'Attendance deleted successfully!');
    }

    public function show(Attendance $attendance): View{
        $attendance = Attendance::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
        
        return view('attendances.show', compact('attendance'));
    }
}