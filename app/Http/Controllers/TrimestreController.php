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
    // Validaciones
    $validator = Validator::make($request->all(), [
        'nombreTrimestre' => 'required|unique:trimestres,nom,NULL,id,curs_id,' . ($cursoAnterior ? $cursoAnterior->id : null),
        'IniciTrimestre' => [
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
        'FinalTrimestre' => [
            'required',
            'date',
            'date_format:Y-m-d',
            'after_or_equal:IniciTrimestre',
            // Validar que la fecha de fin esté dentro del rango del curso
            function ($attribute, $value, $fail) use ($cursoAnterior, $request) {
                $fechaInicio = $request->input('IniciTrimestre');
                if ($value < $fechaInicio) {
                    $fail('La fecha de fin no puede ser anterior a la fecha de inicio.');
                }
                if ($value > $cursoAnterior->data_final) {
                    $fail('La fecha de fin debe estar dentro del rango del curso.');
                }
            },
            // Validar que la fecha de inicio y fin no sean iguales
            'different:IniciTrimestre',
        ],
    ]);

    // Si la validación falla, redireccionar de nuevo al formulario con los mensajes de error
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Crear el trimestre si pasa todas las validaciones
    $trimestre = new Trimestre();
    $trimestre->curs_id = $cursoAnterior ? $cursoAnterior->id : null; // Asignar el ID del último curso
    $trimestre->nom = $request->input('nombreTrimestre');
    $trimestre->data_inici = $request->input('IniciTrimestre');
    $trimestre->data_final = $request->input('FinalTrimestre');
    $trimestre->save();

    // Redireccionar de vuelta al formulario de creación de trimestres
    if ($ultimosTresTrimestres->count() === 2) {
        // Si se han creado tres trimestres, redirigir a la página curs.festiu
        return redirect()->route('curs.festiu.create', ['cur' => $cursoAnterior ? $cursoAnterior->id : null]);
    } else {
        // Si no se han creado tres trimestres, redirigir al formulario de creación de trimestres
        return redirect()->route('curs.trimestre.create', ['cur' => $cursoAnterior ? $cursoAnterior->id : null]);
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
    return view('editarTrim', compact('curs', 'trimestre'));
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
        return view('editarTotCurs', compact('curs', 'trimestres', 'festivos'));
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cur, Trimestre $trimestre)
    {
        // Eliminar el trimestre
        $trimestre->delete();

        // Redireccionar de vuelta al formulario de creación de trimestres
        return redirect()->back()->with('success', 'Trimestre eliminado correctamente');
    }
}

