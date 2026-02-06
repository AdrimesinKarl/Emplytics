<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
    ];

    // Convert database strings into PHP date/time objects automatically
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in' => 'datetime:H:i',
            'check_out' => 'datetime:H:i',
        ];
    }

    // Get the employee who owns this record
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate hours worked for this specific day.
     * Accessible via: $attendance->hours_worked
     */
    protected function hoursWorked(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->check_in || !$this->check_out) {
                    return 0;
                }

                // Finds the difference between clock-out and clock-in
                return round($this->check_out->diffInMinutes($this->check_in) / 60, 2);
            }
        );
    }
}