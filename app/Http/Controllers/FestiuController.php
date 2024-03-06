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
        $curs = Curs::find($cursoAnterior->id); // Obtener el curso correspondiente
        return view('formulariFest', compact('festius', 'curs'));
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
    return view('editarFest', compact('curs', 'festiu'));
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
    return view('editarTotCurs', compact('curs', 'trimestres', 'festivos'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Festiu $festiu)
    {
        //
    }
}
