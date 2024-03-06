<?php

namespace App\Http\Controllers;

use App\Models\UF;
use Illuminate\Http\Request;
use App\Models\Curs;
use App\Models\Modul;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;


class UfController extends Controller
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
    public function create($modulId)
{
    $modul = Modul::find($modulId);
    if (Auth::check() && Auth::user()->name === 'admin') {
        return view('formUf')->with('modul', $modul);
    } else {
        return view('error');
    }
}

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $modulId)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombreUf' => 'required|string|max:255',
            'nSetmanes' => 'required|numeric',
            'ordre' => 'required|numeric'
        ]);
    
        // Crear una nueva instancia del modelo UF
        $uf = new UF();
        $uf->nom = $request->input('nombreUf');
        $uf->setmanes = $request->input('nSetmanes');
        $uf->ordre = $request->input('ordre');
        $uf->modul_id = $modulId; // Asignar el modul_id proporcionado en la URL
        $uf->save();
    
        // Redireccionar o devolver una respuesta según tus necesidades
        return redirect()->route('curs.uf.create', ['cur' => $modulId])->with('success', 'Unitat formativa creada exitosament');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(UF $uF)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UF $uF)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UF $uF)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UF $uF)
    {
        //
    }
}
