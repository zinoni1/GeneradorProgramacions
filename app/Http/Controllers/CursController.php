<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Trimestre;
use App\Models\Festiu;
use Excel;
use App\Exports\CursExport;


class CursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curs::all(); // Obtener todos los cursos
        return view('calendaris', ['cursos' => $cursos]); // Pasar la variable $cursos a la vista 'calendari'
    }

    public function store(Request $request)
    {
        // Verificar si el campo 'nom' está presente en la solicitud
        if ($request->has('nom')) {
            $curs = new Curs(); // Crear una nueva instancia del modelo Curs

            // Asignar los valores recibidos del formulario
            $curs->nom = $request->input('nom');
            $curs->data_inici = $request->input('data_inici');
            $curs->data_final = $request->input('data_final');

            // Guardar el curso en la base de datos
            $curs->save();
        }
        return redirect()->route('curs.trimestre.create', ['cur' => $curs->id]); // Pasar el ID del curso
    }

/**
     * Show the form for creating a new resource.
     */
/**
 * Show the form for creating a new resource.
 */
public function create()
{
    $curs = new Curs(); // Crear una nueva instancia de Curs
    if (Auth::check() && Auth::user()->name === 'admin') {
        // Si cumple con los criterios de autorización, mostrar la vista 'formulari' con la variable $curs
        return view('formulari', compact('curs'));
    } else {
        // Si no cumple con los criterios, redireccionar a una página de error
        return view('error');
    }
}

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $curs = Curs::find($id); // Obtener el curso con el ID proporcionado
        return view('calendari', ['curs' => $curs]); // Pasar las variables $curs, $trimestres y $festius a la vista 'curs'
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curs $curs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curs $curs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curs $curs)
    {
        //
    }

    public function exportCurs()
{
    $fileName = 'curs.xlsx';
    return Excel::download(new CursExport, $fileName);
}


}
