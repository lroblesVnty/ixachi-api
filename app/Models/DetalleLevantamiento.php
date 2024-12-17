<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleLevantamiento extends Model {
    use HasFactory;
    protected $table='gesdetallelevantamientos';
    public $timestamps=false;
    protected $primaryKey='iddetalleLevantamiento';
    protected $fillable=['tipoLinea','linea','estacaIni','mtsIni','estacaFin','mtsFin','metros','metros2','km','ha','idCultivo'];

    public function levantamiento(): BelongsTo{
        //2do arg:FK, 3arg:PK de este modelo(levantamiento)  (padre)
        return $this->belongsTo(Levantamiento::class,'idLevantamiento','idLevantamiento');
    }
    

}
