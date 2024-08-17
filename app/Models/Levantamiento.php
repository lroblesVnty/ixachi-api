<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Levantamiento extends Model{
    use HasFactory;

    protected $table='gesLevantamientos';
    public $timestamps=false;
    protected $primaryKey='IdLevantamiento';

    public function permiso(): BelongsTo{
        //2do arg:FK, 3arg:PK de este modelo padre(gespermisos)
        return $this->belongsTo(Permiso::class,'IdPermiso','IdPermiso');
    }

}
