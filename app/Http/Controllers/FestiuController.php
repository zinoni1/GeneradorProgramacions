<?php

namespace App\Http\Controllers;

use App\Models\Festiu;
use App\Models\Trimestre;
use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $curs = Curs::find($cursoAnterior->id); // Obtener el curso correspondiente
        return view('formulariFest')->with('festius', $festius)->with('curs', $curs);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cursoAnterior = Curs::orderByDesc('id')->first();
    
        // Definir les regles de validació per a les dates i el nom
        $rules = [
            'nombreFestivo' => [
                'required',
                'unique:festius,nom,NULL,id,curs_id,' . ($cursoAnterior ? $cursoAnterior->id : null),
            ],
            'IniciFestivo' => [
                'required',
                'date',
                'date_format:Y-m-d',
                // Validar que la data d'inici estigui dins del rang del curs
                function ($attribute, $value, $fail) use ($cursoAnterior) {
                    if ($value < $cursoAnterior->data_inici || $value > $cursoAnterior->data_final) {
                        $fail('La data d\'inici ha d\'estar dins del rang del curs.');
                    }
                },
            ],
            'FinalFestivo' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:IniciFestivo',
                // Validar que la data de fi estigui dins del rang del curs
                function ($attribute, $value, $fail) use ($cursoAnterior, $request) {
                    $fechaInicio = $request->input('IniciFestivo');
                    if ($value < $fechaInicio) {
                        $fail('La data de fi no pot ser anterior a la data d\'inici.');
                    }
                    if ($value > $cursoAnterior->data_final) {
                        $fail('La data de fi ha d\'estar dins del rang del curs.');
                    }
                    // Verificar si hi ha festius amb les mateixes dates
                    $festivosExist = Festiu::where('data_inici', $fechaInicio)->where('data_final', $value)->exists();
                    if ($festivosExist) {
                        $fail('Ja existeix un festiu amb aquestes dates.');
                    }
                },
            ],
        ];
    
        // Missatges d'error personalitzats
        $messages = [
            'nombreFestivo.required' => 'El nom del festiu és obligatori.',
            'nombreFestivo.unique' => 'Ja existeix un festiu amb aquest nom.',
            'IniciFestivo.required' => 'La data d\'inici és obligatòria.',
            'IniciFestivo.date' => 'La data d\'inici ha de ser una data vàlida.',
            'IniciFestivo.date_format' => 'La data d\'inici ha de tenir el format YYYY-MM-DD.',
            'FinalFestivo.required' => 'La data de fi és obligatòria.',
            'FinalFestivo.date' => 'La data de fi ha de ser una data vàlida.',
            'FinalFestivo.date_format' => 'La data de fi ha de tenir el format YYYY-MM-DD.',
            'FinalFestivo.after_or_equal' => 'La data de fi ha de ser igual o posterior a la data d\'inici.',
        ];
    
        // Validar les entrades del formulari amb les regles definides
        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $festiu = new Festiu();
        $festiu->curs_id = $cursoAnterior ? $cursoAnterior->id : null;
        $festiu->nom = $request->input('nombreFestivo');
        $festiu->tipus = $request->input('tipoFestivo');
        $festiu->data_inici = $request->input('IniciFestivo');
        $festiu->data_final = $request->input('FinalFestivo');
        $festiu->save();
    
        return redirect()->route('curs.festiu.create', ['cur' => $cursoAnterior ? $cursoAnterior->id : null]);
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
    public function edit($curs_id, $trimestre_id)
    {
        $curs = Curs::findOrFail($curs_id);
        $festiu = Festiu::findOrFail($trimestre_id);
        return view('editarFest')->with('curs', $curs)->with('festiu', $festiu);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $festiu_id)
    {
        // Obtener el festivo a actualizar
        $festiu = Festiu::findOrFail($festiu_id);

        // Validar los datos del formulario
        $request->validate([
            'nom' => 'required',
            'data_inici' => 'required|date',
            'data_final' => 'required|date|after_or_equal:data_inici',
        ]);

        // Actualizar los atributos del festivo con los nuevos valores del formulario
        $festiu->nom = $request->input('nom');
        $festiu->data_inici = $request->input('data_inici');
        $festiu->data_final = $request->input('data_final');

        // Guardar los cambios en la base de datos
        $festiu->save();

        // Obtener el curso asociado con este festivo
        $curs = $festiu->curs;

        // Obtener todos los trimestres asociados con este curso
        $trimestres = Trimestre::where('curs_id', $id)->get();

        // Obtener todos los festivos asociados con este curso
        $festivos = Festiu::where('curs_id', $id)->get();

        // Retornar la vista 'editarTotCurs' con los datos necesarios
        return view('editarTotCurs')->with('curs', $curs)->with('trimestres', $trimestres)->with('festivos', $festivos);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cur, Festiu $festiu)
    {
        $festiu->delete();
    
        return redirect()->back()->with('success', 'Festiu eliminat correctament');
    }
}
