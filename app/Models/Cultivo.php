<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model{
    use HasFactory;

    protected $table='gescultivostab';
    public $timestamps=false;
    protected $primaryKey='IdCultivo';
}