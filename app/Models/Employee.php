<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    // Fields that can be filled using the form
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'position',
        'hourly_rate'
    ];

    // Link to attendance records
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // Link to payroll history
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
    
    // Link to user account
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate estimated payroll for the current month.
     * Accessible via: $employee->monthly_payroll
     */
    protected function monthlyPayroll(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Sum up hours worked this month and multiply by rate
                $totalHours = $this->attendances()
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)
                    ->get()
                    ->sum('hours_worked');

                return round($totalHours * $this->hourly_rate, 2);
            }
        );
    }
}