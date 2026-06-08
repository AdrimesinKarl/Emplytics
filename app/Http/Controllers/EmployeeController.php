<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Handles all administrative actions for Employee management,
 * including listing, searching, creating, updating, and deleting.
 */
class EmployeeController extends Controller
{
    private function getPrefix()
    {
        return auth()->user()->role . '.';
    }
    //@param Request $request
    //@return View
    
    public function index(Request $request): View
    {
        $employees = Employee::query()
            // Only apply the search filter if the search input is not empty
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                
                // Grouping OR clauses to ensure they don't interfere with other constraints
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                    ->orWhere('position', 'like', "%{$search}%");
                });
            })
            ->latest() // Order by the most recently created
            ->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return View
     */
        public function create(): View
    {
        $prefix = $this->getPrefix();

        return view('employees.create');
    }

    /**
     * Store a newly created employee in the database.
     * * Validates input before persisting data to ensure data integrity.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Define validation rules for a new employee record
        $validated = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'position'    => ['required', 'string', 'max:255'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
        ]);

        // Create a new employee record using the validated data
        Employee::create([
        'user_id' => auth()->id(),
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'position' => $request->position,
        'hourly_rate' => $request->hourly_rate,
    ]);
        $prefix = $this->getPrefix();

        // Redirect with a success notification
        return redirect()->route($prefix . 'employees.index')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Show the form for editing an existing employee.
     *
     * @param Employee $employee (Injected via Route Model Binding)
     * @return View
     */
    public function edit(Employee $employee): View
    {
        return view('employees.edit', compact('employee'));
    }
    /**
     * Update the specified employee in the database.
     *
     * @param Request $request
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        // Validation rules, ignoring the current employee ID for the unique email check
        $validated = $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name'   => ['required', 'string', 'max:255'],
            'position'    => ['required', 'string', 'max:255'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
        ]);

        // Update the model instance with validated data
        $employee->update($validated);

        $prefix = $this->getPrefix();

        return redirect()->route($prefix . 'employees.index')
            ->with('success', 'Employee updated successfully');
    }
    /**
     * Remove the specified employee from the database.
     *
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        // Delete the record from the database
        $employee->delete();

        $prefix = $this->getPrefix();

        return redirect()->route($prefix . 'employees.index')
            ->with('success', 'Employee deleted successfully');
    }
}