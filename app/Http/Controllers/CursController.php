<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Festiu;
use Excel;
use App\Exports\CursExport;
use App\Models\Trimestre;
use App\Models\Cicle;
use App\Models\Modul;
use App\Models\Uf;


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
        // Validación de campos
        $request->validate([
            'nom' => 'required|string',
            'data_inici' => 'required|date|after_or_equal:2020-01-01',
            'data_final' => 'required|date|after:data_inici',
        ], [
            'nom.required' => 'El nom del curs és obligatori.',
            'nom.string' => 'El nom del curs ha de ser una cadena de caràcters.',
            'data_inici.after_or_equal' => 'La data d\'inici del curs ha de ser a partir de l\'any 2020.',
            'data_final.after' => 'La data final ha de ser posterior a la data d\'inici del curs.',
        ]);
        
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
        
        return redirect()->route('curs.trimestre.create', ['cur' => $curs->id])
                         ->withInput($request->except('nom'));
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
        return view('formulari')->with('curs', $curs);
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
    public function edit($id)
    {
        $curs = Curs::findOrFail($id);
        return view('editarCurs')->with('curs', $curs);
    }

    public function editTot($id)
    {
        // Obtener el curso con el ID proporcionado
        $curs = Curs::findOrFail($id);

        // Obtener todos los trimestres asociados con este curso
        $trimestres = Trimestre::where('curs_id', $id)->get();

        // Obtener todos los festivos asociados con este curso
        $festivos = Festiu::where('curs_id', $id)->get();

        // Retornar la vista 'editarTotCurs' con los datos necesarios
        return view('editarTotCurs')->with('curs', $curs)->with('trimestres', $trimestres)->with('festivos', $festivos);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nom' => 'required',
            'data_inici' => 'required|date',
            'data_final' => 'required|date|after_or_equal:data_inici',
        ]);

        // Encontrar el curso a actualizar
        $curs = Curs::findOrFail($id);

        // Actualizar los atributos del curso con los nuevos valores del formulario
        $curs->nom = $request->input('nom');
        $curs->data_inici = $request->input('data_inici');
        $curs->data_final = $request->input('data_final');

        // Guardar los cambios en la base de datos
        $curs->save();

        $trimestres = Trimestre::where('curs_id', $id)->get();

        // Obtener todos los festivos asociados con este curso
        $festivos = Festiu::where('curs_id', $id)->get();

        // Retornar la vista 'editarTotCurs' con los datos necesarios
        return view('editarTotCurs')->with('curs', $curs)->with('trimestres', $trimestres)->with('festivos', $festivos);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el curso por su ID
        $curs = Curs::findOrFail($id);
    
        // Eliminar todos los trimestres asociados a este curso
        Trimestre::where('curs_id', $id)->delete();
    
        // Eliminar todos los ciclos asociados a este curso
        Cicle::where('curs_id', $id)->delete();
    
        // Eliminar todos los módulos asociados a los ciclos de este curso
        Modul::whereIn('cicle_id', function($query) use ($id) {
            $query->select('id')->from('cicles')->where('curs_id', $id);
        })->delete();
    
        // Eliminar todos los ufs asociados a los módulos de los ciclos de este curso
        Uf::whereIn('modul_id', function($query) use ($id) {
            $query->select('id')->from('moduls')->whereIn('cicle_id', function($query) use ($id) {
                $query->select('id')->from('cicles')->where('curs_id', $id);
            });
        })->delete();
    
        // Eliminar el curso
        $curs->delete();
    
        // Redireccionar a la página de calendarios o cualquier otra página deseada
        $cursos = Curs::all();
        return view('calendaris', ['cursos' => $cursos]);
    }
    


    public function exportCurs()
{
    $fileName = 'curs.xlsx';
    return Excel::download(new CursExport, $fileName);
}


}
