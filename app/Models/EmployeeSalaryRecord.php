<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_salary_record_id',
        'employee_id',
        'total_additions',
        'total_deductions',
        'final_salary',
        'notes',
        'com_code',
        'added_by',
        'updated_by'
    ];

    public function mainRecord()
    {
        return $this->belongsTo(MainSalaryRecord::class, 'main_salary_record_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function additions()
    {
        return $this->hasMany(EmployeeSalaryAddition::class, 'employee_id', 'employee_id');
    }

    // تقدر تضيف علاقة مع الخصومات لما تعمل جدولها
}
