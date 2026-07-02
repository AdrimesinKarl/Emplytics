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
    private function getPrefix()
    {
        return auth()->user()->role . '.';
    }
    
    public function index(Request $request): View
    {
        // Fetch the authenticated user
        $user = auth()->user();

        // Base query
        $query = $user->role === 'employee'
            ? $user->attendances()
            : Attendance::query();

        // Apply date filter
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Execute query
        $attendances = $query->latest()->get();

        return view('attendances.index', compact('attendances'));
    }

    public function show(Attendance $attendance): View
    {
        //will block employees from viewing records that aren't theirs
        $this->authorize('view' , $attendance);

        return view('attendances.show' , compact('attendance'));
    }
    
    public function create(): View
    {
        // Fetch employees to populate the selection dropdown
        $employees = Employee::orderBy('last_name')->get();

        $prefix = $this->getPrefix();
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
        // validate input
        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date'        => ['required', 'date'],
            'check_in'    => ['nullable', 'date_format:H:i'],
            'check_out'   => ['nullable', 'date_format:H:i'],
        ]);

        Attendance::create($validated);

        $prefix = $this->getPrefix();
        return redirect()->route($prefix . 'attendances.index')
            ->with('success', 'Attendance recorded successfully!');
    }
    /**
     * Show the form for editing a specific attendance record.
     *
     * @param Attendance $attendance (Route Model Binding)
     * @return View
     */

    //fetch employees attendances in order by last name
    public function edit(Attendance $attendance): View
    {
        $this->authorize('update', $attendance);

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
        $this->authorize('update', $attendance);

        $validated = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'date' => ['required', 'date'],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
        ]);

        $attendance->update($validated);

        $prefix = $this->getPrefix();
        return redirect()->route($prefix . 'attendances.index')
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
        $this->authorize('delete', $attendance);

        $attendance->delete();

        $prefix = $this->getPrefix();
        return redirect()->route($prefix . 'attendances.index')
            ->with('success', 'Attendance deleted successfully!');
    }

}