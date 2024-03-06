<?php

namespace App\Http\Controllers;
use App\Models\Festiu;
use App\Models\Curs;
use App\Models\Trimestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        return view('formulariTrim')->with(['trimestres' => $trimestres, 'curs' => $curs]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cursAnterior = Curs::orderByDesc('id')->first(); // Obtenir l'últim curs creat
        $ultimsTresTrimestres = Trimestre::orderByDesc('id')->take(3)->get();

        // Verificar si hi ha almenys tres trimestres creats
        // Verificar si els tres trimestres pertanyen a l'últim curs creat
        // Si no s'han creat tres trimestres o no pertanyen al mateix curs, continuar amb la creació de trimestres
        // Validacions
        $validator = Validator::make($request->all(), [
            'nomTrimestre' => 'required|unique:trimestres,nom,NULL,id,curs_id,' . ($cursAnterior ? $cursAnterior->id : null),
            'IniciTrimestre' => [
                'required',
                'date',
                'date_format:Y-m-d',
                // Validar que la data d'inici estigui dins del rang del curs
                function ($attribute, $value, $fail) use ($cursAnterior) {
                    if ($value < $cursAnterior->data_inici || $value > $cursAnterior->data_final) {
                        $fail('La data d\'inici ha d\'estar dins del rang del curs.');
                    }
                },
            ],
            'FinalTrimestre' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:IniciTrimestre',
                // Validar que la data de fi estigui dins del rang del curs
                function ($attribute, $value, $fail) use ($cursAnterior, $request) {
                    $dataInici = $request->input('IniciTrimestre');
                    if ($value < $dataInici) {
                        $fail('La data de fi no pot ser anterior a la data d\'inici.');
                    }
                    if ($value > $cursAnterior->data_final) {
                        $fail('La data de fi ha d\'estar dins del rang del curs.');
                    }
                },
                // Validar que la data d'inici i fi no siguin iguals
                'different:IniciTrimestre',
            ],
        ]);

        // Si la validació falla, redirigir de nou al formulari amb els missatges d'error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Crear el trimestre si passa totes les validacions
        $trimestre = new Trimestre();
        $trimestre->curs_id = $cursAnterior ? $cursAnterior->id : null; // Assignar l'ID de l'últim curs
        $trimestre->nom = $request->input('nomTrimestre');
        $trimestre->data_inici = $request->input('IniciTrimestre');
        $trimestre->data_final = $request->input('FinalTrimestre');
        $trimestre->save();

        // Redirigir de nou al formulari de creació de trimestres
        if ($ultimsTresTrimestres->count() === 2) {
            // Si s'han creat tres trimestres, redirigir a la pàgina curs.festiu
            return redirect()->route('curs.festiu.create', ['cur' => $cursAnterior ? $cursAnterior->id : null]);
        } else {
            // Si no s'han creat tres trimestres, redirigir al formulari de creació de trimestres
            return redirect()->route('curs.trimestre.create', ['cur' => $cursAnterior ? $cursAnterior->id : null]);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
{

}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($curs_id, $trimestre_id)
    {
        $curs = Curs::findOrFail($curs_id);
        $trimestre = Trimestre::findOrFail($trimestre_id);
        return view('editarTrim')->with(['curs' => $curs, 'trimestre' => $trimestre]);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $trimestre_id)
    {
        // Obtener el trimestre a actualizar
        $trimestre = Trimestre::findOrFail($trimestre_id);
    
        // Validar los datos del formulario
        $request->validate([
            'nom' => 'required',
            'data_inici' => 'required|date',
            'data_final' => 'required|date|after_or_equal:data_inici',
        ]);
    
        // Actualizar los atributos del trimestre con los nuevos valores del formulario
        $trimestre->nom = $request->input('nom');
        $trimestre->data_inici = $request->input('data_inici');
        $trimestre->data_final = $request->input('data_final');
    
        // Guardar los cambios en la base de datos
        $trimestre->save();
    
        // Obtener el curso asociado con este trimestre
        $curs = $trimestre->curs;
    
        // Obtener todos los trimestres asociados con este curso
        $trimestres = Trimestre::where('curs_id', $id)->get();
    
        // Obtener todos los festivos asociados con este curso
        $festivos = Festiu::where('curs_id', $id)->get();
    
        // Retornar la vista 'editarTotCurs' con los datos necesarios
        return view('editarTotCurs')->with(['curs' => $curs, 'trimestres' => $trimestres, 'festivos' => $festivos]);
    }
    




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cur, Trimestre $trimestre)
    {
        // Eliminar el trimestre
        $trimestre->delete();

        // Redireccionar de vuelta al formulario de creación de trimestres
        return redirect()->back()->with('success', 'Trimestre eliminat correctament');
    }
}

