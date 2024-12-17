<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Levantamiento extends Model{
    use HasFactory;

    protected $table='gesLevantamientos';
    public $timestamps=false;
    protected $primaryKey='idLevantamiento';
    protected $fillable=["fechaLevantamiento","observaciones","idPermiso","imgUrl",'idPersonal','numFiniquito'];

    public function permiso(): BelongsTo{
        //2do arg:FK, 3arg:PK de este modelo padre(gespermisos)
        return $this->belongsTo(Permiso::class,'IdPermiso','IdPermiso');
    }

    public function detalles(): HasMany{
        return $this->hasMany(DetalleLevantamiento::class,'idLevantamiento','idLevantamiento');
    }

}
