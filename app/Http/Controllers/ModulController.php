<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use App\Models\Cicle;
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
    public function show(Modul $modul)
    {
        //
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
