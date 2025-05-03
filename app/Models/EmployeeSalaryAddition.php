<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'adtional_type_id', 'value', 'date', 'notes', 'added_by', 'com_code'
    ];

    // علاقة مع الموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // علاقة مع نوع الإضافي
    public function addition_type()
    {
        return $this->belongsTo(AdtionalTypes::class, 'adtional_type_id'); // هنا يجب استخدام 'adtional_type_id' بدلاً من 'addition_type_id'
    }
    
    

    // حساب الراتب الكلي (الراتب الأساسي + الإضافي)
    public function calculateTotalSalary()
    {
        $basicSalary = $this->employee->basic_salary; // تأكد من وجود حقل الراتب الأساسي في جدول الموظفين
        return $basicSalary + $this->value;
    }
}
