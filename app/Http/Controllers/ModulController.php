<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use App\Models\Curs;
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
    public function create($cursId)
    {
        $curs = Curs::find($cursId);
        if (Auth::check() && Auth::user()->name === 'admin') {
            return view('formModul', compact('curs'));
        } else {
            return view('error');
        }
    }


    public function store(Request $request,$cicleId)
    {
  
    
        // Crear una nueva instancia del modelo Modul
        $modul = new Modul();
        $modul->nom = $request->input('nombreModul');
        $modul->cicle_id = $cicleId; // Asignar el cicle_id del formulario
        $modul->save(); // Guardar el modul en la base de datos
    
    
            // Redireccionar a la página de creación de unidades formativas del curso
            return redirect()->route('curs.uf.create', ['cur' => $modul->cicle->curs_id]);
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
