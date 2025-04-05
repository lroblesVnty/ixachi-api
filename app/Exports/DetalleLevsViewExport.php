<?php

namespace App\Exports;

use App\Models\Levantamiento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetalleLevsViewExport implements FromView, ShouldAutoSize, WithStyles{

    protected $id;

    // Recibir el ID en el constructor
    public function __construct($id){
        $this->id = $id;
    }



    public function styles(Worksheet $sheet){
        //$sheet->getStyle('B2')->getFont()->setBold(true);
        return [
            // Style the first row as bold text.
           // 1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'A'  => ['alignment' =>  [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ]],
        ];
    }

    public function view(): View{
        $datos=Levantamiento::with([
            'detalles' => [
                'afectacion:idCultivo,cultivo,precioHectarea',
                'tipLinea',
            ],
        ])
        ->findOrFail($this->id,['idLevantamiento','fechaLevantamiento'])->toArray();
        return view('exports.detalleLevById', [
            'datos' =>   $datos
        ]);
    }

}
