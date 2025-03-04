<?php

namespace App\Models;

use Carbon\Carbon;
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

    // Definimos el mutador para el atributo `created_at_formatted`
    //convención get{NombreDelAtributo}Attribute
    public function getFechaLevFormattedAttribute(){
        // Formateamos la fecha `created_at` al formato `dd-mm-YYYY`
        return Carbon::parse($this->attributes['fechaLevantamiento'])->format('d-m-Y');
    }

}
