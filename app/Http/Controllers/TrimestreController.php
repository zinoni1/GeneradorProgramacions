<?php

namespace App\Http\Controllers;
use App\Models\Festiu;
use App\Models\Curs;
use App\Models\Trimestre;
use Illuminate\Http\Request;

class TrimestreController extends Controller
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
    public function create()
    {
        $cursoAnterior = Curs::orderByDesc('id')->first();
        $trimestres = Trimestre::where('curs_id', $cursoAnterior ? $cursoAnterior->id : null)->get();
        $curs = Curs::find($cursoAnterior->id); // Obtener el curso correspondiente
        return view('formulariTrim', compact('trimestres', 'curs'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cursoAnterior = Curs::orderByDesc('id')->first(); // Obtener el último curso creado
        $ultimosTresTrimestres = Trimestre::orderByDesc('id')->take(3)->get();

        // Verificar si hay al menos tres trimestres creados
        //verificar si los tres trimestres pertenecen al ultimo curso creado




        // Si no se han creado tres trimestres o no pertenecen al mismo curso, continuar con la creación de trimestres
        $trimestre = new Trimestre();
        $trimestre->curs_id = $cursoAnterior ? $cursoAnterior->id : null; // Asignar el ID del último curso
        $trimestre->nom = $request->input('nombreTrimestre');
        $trimestre->data_inici = $request->input('IniciTrimestre');
        $trimestre->data_final = $request->input('FinalTrimestre');
        $trimestre->save();

        if ($ultimosTresTrimestres->count() >= 3) {
            // Verificar si los tres trimestres pertenecen al último curso creado
            $trimestresDelUltimoCurso = $ultimosTresTrimestres->filter(function ($trimestre) use ($cursoAnterior) {
                return $trimestre->curs_id == $cursoAnterior->id;
            });

            if ($trimestresDelUltimoCurso->count() == 2) {
                return redirect()->route('curs.festiu.create', ['cur' => $cursoAnterior ? $cursoAnterior->id : null]);

            }
        }

        return redirect()->route('curs.trimestre.create', ['cur' => $cursoAnterior ? $cursoAnterior->id : null]);


    }



    /**
     * Display the specified resource.
     */
    public function show(Trimestre $trimestre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trimestre $trimestre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trimestre $trimestre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trimestre $trimestre)
    {
        //
    }
}
