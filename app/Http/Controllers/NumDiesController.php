<?php

namespace App\Http\Controllers;

use App\Models\NumDies;
use Illuminate\Http\Request;
use App\Models\Cicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class NumDiesController extends Controller
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
        $cicle = Cicle::findOrFail($cicleId);
        $moduls = $cicle->moduls; // Obtener los módulos asociados con el ciclo
        $relatedCicles = Cicle::where('id', '=', $cicleId)->get();
        return view('formProfe')->with(['cicle' => $cicle, 'cicles' => $relatedCicles, 'moduls' => $moduls]);
    }
    
    
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'cicle_id' => 'required|exists:cicles,id',
            'modul_id' => 'required|exists:moduls,id',
            'dia' => 'required|string',
            'horas' => 'required|numeric',
        ]);
        
        // Crear y almacenar la asignación de días del módulo
        $asignacion = new NumDies();
        $asignacion->cicle_id = $request->input('cicle_id');
        $asignacion->modul_id = $request->input('modul_id');
        $asignacion->dia = $request->input('dia');
        $asignacion->num_sessio = $request->input('horas');
        $asignacion->save();
        
        // Redireccionar a donde desees después de guardar la asignación
        return redirect()->route('dashboard');
    
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(num_dies $num_dies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(num_dies $num_dies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, num_dies $num_dies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(num_dies $num_dies)
    {
        //
    }
} 