<?php

namespace App\Http\Controllers;

use App\Models\Festiu;
use App\Models\Trimestre;
use App\Models\Curs;
use Illuminate\Http\Request;

class FestiuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
{
    $cursoAnterior = Curs::orderByDesc('id')->first();
    $festius = Festiu::where('curs_id', $cursoAnterior ? $cursoAnterior->id : null)->get();
return view('formulariFest', compact('festius'));
}




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cursoAnterior = Curs::orderByDesc('id')->first();
        $festiu = new Festiu(); // Crear una nueva instancia del modelo Curs

        // Asignar los valores recibidos del formulario
        $festiu->curs_id = $cursoAnterior ? $cursoAnterior->id : null;
        $festiu->nom = $request->input('nombreFestivo');
        $festiu->tipus = $request->input('tipoFestivo');
        $festiu->data_inici = $request->input('IniciFestivo');
        $festiu->data_final = $request->input('FinalFestivo');

        // Guardar el curso en la base de datos
        $festiu->save();

        return redirect()->route('festiu.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Festiu $festiu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Festiu $festiu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Festiu $festiu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Festiu $festiu)
    {
        //
    }
}
