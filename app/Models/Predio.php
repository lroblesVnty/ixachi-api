<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function permiso(): HasOne{
           //2do arg:FK, 3arg:PK de este modelo(padre)(tabla gespredios)
        return $this->hasOne(Permiso::class,'IdPredio','IdPredio');
    }
}
