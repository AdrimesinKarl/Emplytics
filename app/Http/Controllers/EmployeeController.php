<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; //tells php where the class is

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        // Retrieve all employees from the database with optional search filtering
        $employees = Employee::query()
        ->when($request->search, function($q, $search) {
            $q->where('first_name', 'like', "%{$search}%") //where clause to filter employees based on search input
            ->orWhere('last_name', 'like', "%{$search}%") //orWhere clause to include multiple conditions "OR logic"
            ->orWhere('position', 'like', "%{$search}%"); //like used to match patterns in a column //partial matches
    })
        ->get();

    return view('employees.index', compact('employees')); //past the data to the view
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create'); //return the create employee form view
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        //validate the incoming request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
        ]);

    // Create a new employee record
    Employee::create($validated);

    //redirect to the employee list with a success message
    return redirect()->route('employees.index')->with('success', 'Employee created!');

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee')); //return the edit employee form view with the employee data
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'=> 'required|email|unique:employees,email,'.$employee->id,
            'position' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:0',
        ]);

        $employee->update($request->all()); //update the employee record with the validated data

        return redirect()->route('employees.index')
        ->with('success', 'Employee updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')
        ->with('success', 'Employee deleted successfully');
    }
}
