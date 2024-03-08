<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use App\Models\Cicle;
use App\Models\Curs;
use App\Models\Trimestre;
use App\Models\Festiu;
use App\Models\UF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($cicleId)
    {
        $cicle = Cicle::find($cicleId); // Obtener el curso por su ID
        if (Auth::check() && Auth::user()->name === 'admin') {
            // Si cumple con los criterios de autorización, mostrar la vista 'formulari' con la variable $curs
            return view('formModul', ['cicle' => $cicle]);
        } else {
            // Si no cumple con los criterios, redireccionar a una página de error
            return view('error');
        }
    }




    public function store(Request $request, $cicleId)
    {
        // Crear una nueva instancia del modelo Modul
        $modul = new Modul();
        $modul->nom = $request->input('nombreModul');
        $modul->cicle_id = $cicleId; // Asignar el cicle_id del formulario
        $modul->save(); // Guardar el modul en la base de datos

        // Verificar si el módulo tiene un ciclo asociado
        if ($modul->cicle) {
            // Redireccionar a la página de creación de unidades formativas del curso
            return redirect()->route('modul.uf.create', ['modul' => $modul->id]);
        } else {
            // Manejar el caso donde el módulo no tiene un ciclo asociado
            // Por ejemplo, redirigir a una página de error o a una página predeterminada
            return redirect()->route('error');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($cursId, $cicleId, $modulId)
    {
        // Obtener el módulo y el curso correspondientes a los IDs proporcionados
        $modul = Modul::findOrFail($modulId);
        $curs = Curs::findOrFail($cursId);

        // Obtener los trimestres de este curso
        $trimestres = Trimestre::where('curs_id', $cursId)->get();

        // Obtener los festivos de este curso
        $festius = Festiu::where('curs_id', $cursId)->get();

        // Obtener las unidades formativas de este módulo
        $ufs = UF::where('modul_id', $modulId)->get();

        // Inicializar el arreglo de eventos
        $events = [];

        // Agregar eventos del curso
        $events[] = [
            'title' => $curs->nom . ' (Inici)',
            'start' => $curs->data_inici,
            'color' => '#FF5733',
        ];
        $events[] = [
            'title' => $curs->nom . ' (Fi)',
            'start' => $curs->data_final,
            'color' => '#FF5733',
        ];

        // Agregar eventos de trimestres
        foreach ($trimestres as $trimestre) {
            $events[] = [
                'title' => $trimestre->nom . ' (Inici)',
                'start' => $trimestre->data_inici,
                'color' => '#0000FF',
            ];
            $events[] = [
                'title' => $trimestre->nom . ' (Fi)',
                'start' => $trimestre->data_final,
                'color' => '#0000FF',
            ];
        }

        // Agregar eventos de festivos
        foreach ($festius as $festiu) {
            $events[] = [
                'title' => $festiu->nom . ' (Inici)',
                'start' => $festiu->data_inici,
                'color' => '#00FF00',
            ];
            $events[] = [
                'title' => $festiu->nom . ' (Fi)',
                'start' => $festiu->data_final,
                'color' => '#00FF00',
            ];
        }

        // Agregar eventos de inicio de unidades formativas (UF)
        foreach ($ufs as $uf) {
            $events[] = [
                'title' => $uf->nom . ' (Inici)',
                'start' => $uf->data_inici,
                'color' => '#FFFF00',
            ];
        }

        // Retornar la vista con los eventos
        return view('showCalendariModul', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modul $modul)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        //
    }
}
