<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
