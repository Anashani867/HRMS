<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MainSalaryRecord extends Model
{
    use HasFactory;

    protected $table = 'main_salary_records';

    protected $fillable = [
        'period_id',
        'com_code',
        'is_open',
        'opened_at',
        'added_by',
        'updated_by',
    ];

    public function period()
{
    return $this->belongsTo(Finance_cln_periods::class, 'period_id');
}

// App\Models\MainSalaryRecord.php
public function Month()
{
    return $this->belongsTo(Monthes::class, 'month_id'); // تأكد من أن الحقل month_id هو الصحيح
}


public function added(){
    return $this->belongsTo('\App\Models\Admin','added_by');
 }
 public function updatedby(){
    return $this->belongsTo('\App\Models\Admin','updated_by');
 }

}
