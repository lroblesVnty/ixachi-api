<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Propietario extends Model
{
    use HasFactory;

    protected $table='gespropietarios';
    public $timestamps=false;
    protected $primaryKey='IdPropietario';
    //public $incrementing=false; if primary key is not autoincrement
    //protected $keyType='string' if pirmaryKey is not int
    //protected $connection='name_con';
   // protected $hidden=['updated_at'];

    public function predios(): HasMany{
        return $this->hasMany('App\Models\Predio','IdPropietario','IdPropietario');
    }
}
