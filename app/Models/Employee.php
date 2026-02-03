<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [ //fillable fields for mass assignment
        'first_name',
        'last_name',
        'email',
        'position',
        'hourly_rate'
    ];
    
    public function getMonthlyPayrollAttribute() //calculate the monthly payroll for the employee
    {
    $totalHours = $this->attendances()
        ->whereMonth('date', now()->month) //this get the attendances for the current month & and sum all hours worked
        ->get()
        ->sum('hours_worked');

    return $totalHours * $this->hourly_rate;
    }

}



