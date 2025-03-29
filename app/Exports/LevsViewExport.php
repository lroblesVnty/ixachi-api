<?php

namespace App\Exports;

use App\Models\Levantamiento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LevsViewExport implements FromView{
    public function view(): View{
        $datos=Levantamiento::with([
            'detalles' => [
                'afectacion:idCultivo,cultivo,precioHectarea',
                'tipLinea',
            ],
        ])
        ->get(['idLevantamiento','fechaLevantamiento'])->toArray();
        return view('exports.detalleLev', [
            'datos' =>   $datos
        ]);
    }

}
