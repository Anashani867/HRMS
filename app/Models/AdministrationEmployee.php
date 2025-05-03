<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrationEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', // أضف هذه السطر
        'department_id',
        'assigned_at',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    

    // العلاقة مع قسم واحد
    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id'); // علاقة مع قسم عبر department_id
    }

    public function added(){
        return $this->belongsTo('\App\Models\Admin','added_by');
     }
     public function updatedby(){
        return $this->belongsTo('\App\Models\Admin','updated_by');
     }
}
