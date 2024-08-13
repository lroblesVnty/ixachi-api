<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permiso extends Model
{
    use HasFactory;

    protected $table='gespermisos';
    public $timestamps=false;
    protected $primaryKey='IdPermiso';

    public function predio(): BelongsTo{
        //2do arg:FK, 3arg:PK de este modelo(padre)
        return $this->belongsTo(Predio::class,'IdPredio','IdPredio');
    }
}