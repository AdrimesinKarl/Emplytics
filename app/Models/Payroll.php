<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
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
    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
