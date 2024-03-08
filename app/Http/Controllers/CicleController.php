<?php

namespace App\Http\Controllers;

use App\Models\Cicle;
use App\Models\Curs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Http\Controllers\CicleController;
use App\Http\Controllers\ModulController;

class CicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request, $cursId)
    {
        // Validar los datos del formulario
        $request->validate([
            'ciclo' => 'required|string|max:255', // Ajusta las reglas de validación según tus necesidades
        ]);

        // Crear una nueva instancia del modelo Cicle
        $cicle = new Cicle();
        $cicle->nom = $request->input('ciclo'); // Obtener el nombre del ciclo del formularioio
        $cicle->curs_id = $cursId; // Asociar el Cicle con el ID del Curs proporcionado

        // Guardar el ciclo en la base de datos
        $cicle->save();

        // Verificar si el ciclo se guardó correctamente
        if ($cicle->id) {
           // Redireccionar a la página de creación de módulos
        return redirect()->route('cicle.modul.create', ['cicle' => $cicle->id]);


        } else {
            // Manejar el caso donde el ciclo no se guardó correctamente
            // Por ejemplo, redirigir a una página de error o a una página predeterminada
            return redirect()->route('error');
        }
    }







    /**
     * Store a newly created resource in storage.
     */
    public function create($cursId)
    {
        $curs = Curs::find($cursId); // Obtener el curso por su ID
        if (Auth::check() && Auth::user()->name === 'admin') {
            // Si cumple con los criterios de autorización, mostrar la vista 'formulari' con la variable $curs
            return view('formulariCicle', ['curs' => $curs]);
        } else {
            // Si no cumple con los criterios, redireccionar a una página de error
            return view('error');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($cursId, $cicleId)
    {
        // Obtener el curso con el ID proporcionado
        $curs = Curs::findOrFail($cursId);

        // Obtener el ciclo con el ID proporcionado
        $cicle = Cicle::findOrFail($cicleId);

        // Obtener todos los módulos asociados al ciclo obtenido
        $moduls = Modul::where('cicle_id', $cicleId)->get();

        // Retornar la vista 'modulsView' con los datos necesarios
        return view('modulsView', compact('curs', 'cicle', 'moduls'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cicle $cicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cicle $cicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cicle $cicle)
    {
        //
    }
}
