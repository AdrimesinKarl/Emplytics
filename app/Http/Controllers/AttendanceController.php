<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Models\Attendance;
    use App\Models\Employee;

    class AttendanceController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            //Retrieve all attendance records from the database
            $attendances = Attendance::all(); //fetch all records
            return view('attendances.index', compact('attendances')); // Pass the data to the view
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            $employees = Employee::all(); // Fetch all employees for the dropdown
            return view('attendances.create', compact('employees'));
        }

        public function edit(Attendance $attendance)
        {
            return view('attendances.edit', compact('attendance')); // Return the edit attendance form view with the specific attendance record
        }
    /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            //
        }
        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
                // Validate the incoming request data
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
            ]);

            // Create a new attendance record
            Attendance::create($validated);

            // Redirect to the attendance list with a success message
            return redirect()->route('attendances.index')->with('success', 'Attendance recorded!');
        }

        public function update (Request $request, Attendance $attendance)
        {
            // Validate the incoming request data
            $validated = $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'check_in'  => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',

            ]);

            // Update the attendance record
            $attendance->update($validated);

            // Redirect to the attendance list with a success message
            return redirect()->route('attendances.index')->with('success', 'Attendance updated!');
        }

        public function destroy(Attendance $attendance)
        {
            $attendance->delete();
            return redirect()->route('attendances.index')->with('success', 'Attendance deleted successfully!');
        }
    }

?>

