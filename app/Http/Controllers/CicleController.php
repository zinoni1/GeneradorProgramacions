<?php

namespace App\Http\Controllers;

use App\Models\Cicle;
use App\Models\Curs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

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
            return redirect()->route('curs.modul.create', ['cur' => $cursId]); // Cambio aquí
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
            return view('formulariCicle', compact('curs'));
        } else {
            // Si no cumple con los criterios, redireccionar a una página de error
            return view('error');
        }
    }
    
 
    /**
     * Display the specified resource.
     */
    public function show(Cicle $cicle)
    {
        //
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
