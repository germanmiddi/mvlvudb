<?php

namespace App\Exports;

use App\Models\Manager\Tramite;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TramitesExport implements FromCollection, WithHeadings
{

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tramite::all();
    }

    public function headings(): array
    {
        return [
            'Num Tramite','Fecha','Observacion','Sede','Canal Atencion','Tipo Tramite','Tipo Institucion','Dependencia','Num Tramite Legacy'
        ];
    }
}
