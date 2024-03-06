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
        return view('formulariFest', compact('festius', 'curs'));
    }
    




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cursoAnterior = Curs::orderByDesc('id')->first();
    
        // Definir las reglas de validación para las fechas y el nombre
        $rules = [
            'nombreFestivo' => [
                'required',
                'unique:festius,nom,NULL,id,curs_id,' . ($cursoAnterior ? $cursoAnterior->id : null),
            ],
            'IniciFestivo' => [
                'required',
                'date',
                'date_format:Y-m-d',
                // Validar que la fecha de inicio esté dentro del rango del curso
                function ($attribute, $value, $fail) use ($cursoAnterior) {
                    if ($value < $cursoAnterior->data_inici || $value > $cursoAnterior->data_final) {
                        $fail('La fecha de inicio debe estar dentro del rango del curso.');
                    }
                },
            ],
            'FinalFestivo' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:IniciFestivo',
                // Validar que la fecha de fin esté dentro del rango del curso
                function ($attribute, $value, $fail) use ($cursoAnterior, $request) {
                    $fechaInicio = $request->input('IniciFestivo');
                    if ($value < $fechaInicio) {
                        $fail('La fecha de fin no puede ser anterior a la fecha de inicio.');
                    }
                    if ($value > $cursoAnterior->data_final) {
                        $fail('La fecha de fin debe estar dentro del rango del curso.');
                    }
                    // Verificar si hay festivos con las mismas fechas
                    $festivosExist = Festiu::where('data_inici', $fechaInicio)->where('data_final', $value)->exists();
                    if ($festivosExist) {
                        $fail('Ya existe un festivo con estas fechas.');
                    }
                },
            ],
        ];
    
        // Mensajes de error personalizados
        $messages = [
            'nombreFestivo.required' => 'El nombre del festivo es requerido.',
            'nombreFestivo.unique' => 'Ya existe un festivo con este nombre.',
            'IniciFestivo.required' => 'La fecha de inicio es requerida.',
            'IniciFestivo.date' => 'La fecha de inicio debe ser una fecha válida.',
            'IniciFestivo.date_format' => 'La fecha de inicio debe tener el formato YYYY-MM-DD.',
            'FinalFestivo.required' => 'La fecha de fin es requerida.',
            'FinalFestivo.date' => 'La fecha de fin debe ser una fecha válida.',
            'FinalFestivo.date_format' => 'La fecha de fin debe tener el formato YYYY-MM-DD.',
            'FinalFestivo.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
        ];
    
        // Validar las entradas del formulario con las reglas definidas
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
    public function destroy($cur, Festiu $festiu)
    {
        $festiu->delete();
    
        return redirect()->back()->with('success', 'Festivo eliminado correctamente');
    }
}
