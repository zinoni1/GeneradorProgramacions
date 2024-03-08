<?php

namespace App\Exports;

use App\Models\Curs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CursExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Obtener todos los cursos con sus festivos asociados
        $cursos = Curs::with('festiu')->get();

        // Preparar los datos para la exportación
        $data = [];

        // Iterar sobre cada curso
        foreach ($cursos as $curso) {
            // Obtener los festivos asociados al curso
            $festivos = $curso->festiu;

            // Iterar sobre los festivos y añadir una fila por cada uno
            foreach ($festivos as $festiu) {
                // Añadir una fila para cada festivo
                $data[] = [
                    'NomCurs' => $curso->nom,
                    'DataIniciCurs' => $curso->data_inici,
                    'DataFinalCurs' => $curso->data_final,
                    'NomFestiu' => $festiu->nom,
                    'DataIniciFestiu' => $festiu->data_inici,
                    'DataFinalFestiu' => $festiu->data_final,
                    'TipusFestiu' => $festiu->tipus,
                ];
            }

            // Si no hay festivos asociados, añadir una fila solo para el curso
            if ($festivos->isEmpty()) {
                $data[] = [
                    'NomCurs' => $curso->nom,
                    'DataIniciCurs' => $curso->data_inici,
                    'DataFinalCurs' => $curso->data_final,
                    'NomFestiu' => '',
                    'DataIniciFestiu' => '',
                    'DataFinalFestiu' => '',
                    'TipusFestiu' => '',
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        // Definir los encabezados de las columnas
        return [
            'NomCurs',
            'DataIniciCurs',
            'DataFinalCurs',
            'NomFestiu',
            'DataIniciFestiu',
            'DataFinalFestiu',
            'TipusFestiu',
        ];
    }
}
