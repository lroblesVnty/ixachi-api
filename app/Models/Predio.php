<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predio extends Model
{
    use HasFactory;

    protected $table='gespredios';
    public $timestamps=false;
    protected $primaryKey='IdPredio';
    //public $incrementing=false; if primary key is not autoincrement
    //protected $keyType='string' if pirmaryKey is not int
    //protected $connection='name_con';
   // protected $hidden=['updated_at'];

    public function propietario(){
        return $this->belongsTo(Propietario::class,'IdPropietario','IdPropietario');
    }
}
