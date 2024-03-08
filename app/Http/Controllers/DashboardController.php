<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use App\Models\Cicle;
use App\Models\Trimestre;
use App\Models\Festiu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $allcursos = Curs::all();
        $allTrimestres = Trimestre::all();
        $allFestius = Festiu::all();
        $cicle = Cicle::find($id);
        $cursos = [];

        foreach ($allcursos as $curs) {
            // Agregar el día de inicio del evento
            $cursos[] = [
                'title' => $curs->nom . ' (Inicio)',
                'start' => $curs->data_inici,
                'color' => '#FF5733',
            ];

            // Agregar el día de fin del evento
            $cursos[] = [
                'title' => $curs->nom . ' (Fin)',
                'start' => $curs->data_final,
                'color' => '#FF5733',
            ];
        }

        foreach ($allTrimestres as $trimestre) {
            // Agregar el día de inicio del evento
            $cursos[] = [
                'title' => $trimestre->nom . ' (Inicio)',
                'start' => $trimestre->data_inici,
                'color' => '#0000FF',
            ];

            // Agregar el día de fin del evento
            $cursos[] = [
                'title' => $trimestre->nom . ' (Fin)',
                'start' => $trimestre->data_final,
                'color' => '#0000FF',
            ];
        }

        foreach ($allFestius as $festiu) {
            // Agregar el día de inicio del evento
            $cursos[] = [
                'title' => $festiu->nom,
                'start' => $festiu->data_inici,
                'end'   => $festiu->data_final,
                'color' => '#BDECB6',
            ];
        }

        return view('dashboard', [
            'cicle' => $cicle, // Pasa la variable $cicle a la vista
            'cursos' => $cursos,
            'allcursos' => $allcursos,
            'allTrimestres' => $allTrimestres,
            'allFestius' => $allFestius
        ]);
        
    }
}
