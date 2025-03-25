<?php

namespace App\Exports;

use App\Models\Levantamiento;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable; // Agrega esta línea

class LevsExport implements  FromQuery, WithHeadings{
    use Exportable; 
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query(){
        Levantamiento::with([
            'detalles' => [
                'afectacion:idCultivo,cultivo,precioHectarea',
                'tipLinea',
            ],
        ])
        ->findOrFail(25,['idLevantamiento','fechaLevantamiento','imgUrl']);
        //TODO CREAR LA CONSULTA PERSONALIZADA

       
        
       
    }

    public function headings(): array{
        return [
            'ID',
            'Nombre',
            'Email',
            'Fecha de Creación',
            'Fecha de Actualización',
        ];
    }


}
