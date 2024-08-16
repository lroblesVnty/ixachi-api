<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model{
    use HasFactory;

    protected $table='proyectos';
    public $timestamps=false;
    protected $primaryKey='nombreProyecto';
    public $incrementing=false; //if primary key is not autoincrement
    protected $keyType='string'; //if pirmaryKey is not int
}
