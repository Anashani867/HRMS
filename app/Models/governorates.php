<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class governorates extends Model
{
    use HasFactory;
    protected $table='governorates';
    protected $guarded=[];

       public function added(){
        return $this->belongsTo('\App\Models\Admin','added_by');
     }
     public function updatedby(){
        return $this->belongsTo('\App\Models\Admin','updated_by');
     }
     public function governorates(){
        return $this->belongsTo('\App\Models\governorates','governorates_id');
     }

     public function country() {
      return $this->belongsTo(Countries::class, 'countires_id');
  }

  public function centers() {
      return $this->hasMany(centers::class, 'governorates_id');
  }
}
