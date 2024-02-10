<?php

namespace App\Exports;

use App\Models\Curs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CursExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Obtener los cursos y mapearlos para incluir también la información de Trimestre y Festiu
        return Curs::with('trimestre', 'festiu')->get()->map(function ($curs) {
            $trimestres = $curs->trimestre->map(function ($trimestre) {
                return [
                    'Curs: ' . $trimestre->nom,
                    $trimestre->data_inici,
                    $trimestre->data_final,
                ];
            });
            $festius = $curs->festiu->map(function ($festiu) {
                return [
                    'Festiu: ' . $festiu->nom,
                    $festiu->data_inici,
                    $festiu->data_final,
                    $festiu->tipus,
                ];
            });
            return $trimestres->merge($festius);
        });
    }

    /**
     * Specify the headings of the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tipo',
            'Data Inici',
            'Data Final',
            'Tipus',
        ];
    }
}
