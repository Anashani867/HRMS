<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function added(){
        return $this->belongsTo('\App\Models\Admin','added_by');
     }
     public function updatedby(){
        return $this->belongsTo('\App\Models\Admin','updated_by');
     }

     // في موديل الموظف Employee.php
public function salaryRecords()
{
    return $this->hasMany(EmployeeSalaryRecord::class);
}
public function additions()
{
    return $this->hasMany(EmployeeSalaryAddition::class, 'employee_id');
}

public function deductions()
{
    return $this->hasMany(EmployeeSalaryDeduction::class, 'employee_id');
}


public function calculateFinalSalary($attendanceStatus, $date)
{
    $dailySalary = $this->daily_salary; // الراتب اليومي

    // قيمة الإضافة على الراتب
    $additions = EmployeeSalaryAddition::where('employee_id', $this->id)
                                       ->where('date', $date)
                                       ->sum('value');
    
    // حساب قيمة الغياب
    $deductions = 0;
    if ($attendanceStatus == 'absent') {
        $deductions = $dailySalary; // خصم الراتب اليومي بالكامل إذا كان غائبًا
    }

    // حساب الراتب النهائي
    $finalSalary = $dailySalary + $additions - $deductions;

    return [
        'final_salary' => $finalSalary,
        'additions' => $additions,
        'deductions' => $deductions,
    ];
}


}
