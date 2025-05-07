<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'discount_type_id',
        'value',
        'date',
        'notes',
        'added_by',
        'com_code',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function deduction_type()
    {
        return $this->belongsTo(DiscountsType::class, 'discount_type_id');
    }    
    

}
