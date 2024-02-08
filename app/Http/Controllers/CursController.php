<?php

namespace App\Http\Controllers;

use App\Models\Curs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trimestre;
use App\Models\Festiu;


class CursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curs = Curs::all();
        if (Auth::check() && Auth::user()->name === 'admin') {
            // Si cumple con los criterios de autorización, mostrar la vista 'curs'
            return view('formulari');
        } else {
            // Si no cumple con los criterios, redireccionar a una página de error
            return view('error');
        }
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

            // Guardar los trimestres asociados al curso
            $trimestresData = json_decode($request->input('trimestresData'), true);
            if (!empty($trimestresData)) {
                foreach ($trimestresData as $trimestreData) {
                    $trimestre = new Trimestre();
                    $trimestre->nom = $trimestreData['nom'];
                    $trimestre->data_inici = $trimestreData['inicio'];
                    $trimestre->data_final = $trimestreData['fin'];
                    $trimestre->curs_id = $curs->id; // Asignar el id del curso
                    $trimestre->save();
                }
            }


        }
            $festiusData = json_decode($request->input('festiusData'), true);
            if (!empty($festiusData)) {
              foreach ($festiusData as $festiuData) {
                $festiu = new Festiu();
                $festiu->nom = $festiuData['nom'];
                $festiu->data_inici = $festiuData['inicio'];
                $festiu->data_final = $festiuData['fin'];
                $festiu->tipus = $festiuData['tipus'];
                $festiu->curs_id = $curs->id;
                $festiu->save();
              }
            }
    }
/**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Curs $curs)
    {
        //
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
}
