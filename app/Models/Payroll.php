<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'total_hours',
        'gross_pay',
        'deductions',
        'net_pay',
        'generated_at',
    ];

    // Ensure dates and numbers are formatted correctly when used
    protected function casts(): array
    {
        return [
            'pay_period_start' => 'date',
            'pay_period_end'   => 'date',
            'generated_at'     => 'datetime',
            'total_hours'      => 'decimal:2',
            'gross_pay'        => 'decimal:2',
            'deductions'       => 'decimal:2',
            'net_pay'          => 'decimal:2',
        ];
    }

    // Get the employee this payroll belongs to
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}