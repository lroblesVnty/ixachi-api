<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLinea extends Model{
    use HasFactory;

    protected $table='gescattiposlinea';
    public $timestamps=false;
    protected $primaryKey='idTipoLinea';
    public $incrementing=false; //if primary key is not autoincrement
    protected $keyType='string';// if pirmaryKey is not int
    protected $fillable=["tipoLinea"];
    //protected $connection='name_con';
   // protected $hidden=['updated_at'];
}
