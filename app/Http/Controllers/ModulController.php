<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use App\Models\Cicle;
use App\Models\Curs;
use App\Models\Trimestre;
use App\Models\Festiu;
use App\Models\UF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use App\Models\NumDies;
use Carbon\Carbon;


class ModulController extends Controller
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
    public function create($cicleId)
    {
        $cicle = Cicle::find($cicleId); // Obtener el curso por su ID
        if (Auth::check() && Auth::user()->name === 'admin') {
            // Si cumple con los criterios de autorización, mostrar la vista 'formulari' con la variable $curs
            return view('formModul', ['cicle' => $cicle]);
        } else {
            // Si no cumple con los criterios, redireccionar a una página de error
            return view('error');
        }
    }
    




    public function store(Request $request, $cicleId)
    {
        // Crear una nueva instancia del modelo Modul
        $modul = new Modul();
        $modul->nom = $request->input('nombreModul');
        $modul->cicle_id = $cicleId; // Asignar el cicle_id del formulario
        $modul->save(); // Guardar el modul en la base de datos

        // Verificar si el módulo tiene un ciclo asociado
        if ($modul->cicle) {
            // Redireccionar a la página de creación de unidades formativas del curso
            return redirect()->route('modul.uf.create', ['modul' => $modul->id]);
        } else {
            // Manejar el caso donde el módulo no tiene un ciclo asociado
            // Por ejemplo, redirigir a una página de error o a una página predeterminada
            return redirect()->route('error');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($cursId, $cicleId, $modulId)
    {
        // Obtener el módulo y el curso correspondientes a los IDs proporcionados
        $modul = Modul::findOrFail($modulId);
        $curs = Curs::findOrFail($cursId);
        $cicle = Cicle::findOrFail($cicleId);
        $ufs = UF::where('modul_id', $modulId)->orderBy('ordre')->get();
    
        $diesModul = NumDies::where('modul_id', $modulId)->get();
    
        // Obtener la fecha de inicio y fin del curso
        $fechaInicioCurso = Carbon::parse($curs->data_inici)->setTimezone('UTC');
        $fechaFinCurso = Carbon::parse($curs->data_final)->setTimezone('UTC');  
    
        // Obtener los trimestres de este curso
        $trimestres = Trimestre::where('curs_id', $cursId)->get();
    
        // Obtener los festivos de este curso
        $festius = Festiu::where('curs_id', $cursId)->get();
    
        // Obtener las unidades formativas de este módulo
        $ufs = UF::where('modul_id', $modulId)->get();
       $fechaInicioUF = Carbon::parse($fechaInicioCurso);
    
        // Inicializar el arreglo de eventos
        $events = [];
    
        // Agregar eventos del curso
        $events[] = [
            'title' => $curs->nom . ' (Inici)',
            'start' => $curs->data_inici,
            'color' => '#FF5733',
        ];
        $events[] = [
            'title' => $curs->nom . ' (Fi)',
            'start' => $curs->data_final,
            'color' => '#FF5733',
        ];
        foreach ($diesModul as $diaModul) {
            // Traducir el nombre del día de la semana a inglés
            $englishDay = $this->translateDayOfWeekToEnglish($diaModul->dia);
            
            if ($englishDay) {
                // Obtener la fecha del primer día de la semana correspondiente a la fecha de inicio del curso
                $nextDay = Carbon::parse($fechaInicioCurso)->startOfWeek();
                
                // Mover al siguiente día específico de la semana
                $nextDay = $nextDay->next($englishDay);
                
                // Iterar mientras el próximo día esté dentro del rango de fechas del curso
                while ($nextDay->between($fechaInicioCurso, $fechaFinCurso)) {
                    // Verificar si el día es un festivo
                    $esFestiu = false;
                    foreach ($festius as $festiu) {
                        if ($nextDay->between($festiu->data_inici, $festiu->data_final)) {
                            // Si es festivo, marcar la bandera y salir del bucle
                            $esFestiu = true;
                            break;
                        }
                    }
                    
                    // Si no es festivo, agregar el día al calendario
                    if (!$esFestiu) {
                        $events[] = [
                            'title' =>  $diaModul->num_sessio . ' Hores ', // Usar el campo num_sessio como título
                            'start' => $nextDay->format('Y-m-d'),
                            'color' => '#FF0000', // Color rojo para resaltar el día
                        ];
                    }
                    
                    // Mover al siguiente día específico de la semana
                    $nextDay->addWeek();
                }
            }
        }
        
    
        // Agregar eventos de trimestres
        foreach ($trimestres as $trimestre) {
            $events[] = [
                'title' => $trimestre->nom . ' Trimestre (Inici)',
                'start' => $trimestre->data_inici,
                'color' => '#0000FF',
            ];
            $events[] = [
                'title' => $trimestre->nom . ' Trimestre (Fi)',
                'start' => $trimestre->data_final,
                'color' => '#0000FF',
            ];
        }
    
        // Agregar eventos de festivos
        foreach ($festius as $festiu) {
            $events[] = [
                'title' => $festiu->nom . ' (Inici)',
                'start' => $festiu->data_inici,
                'color' => '#00FF00',
            ];
            $events[] = [
                'title' => $festiu->nom . ' (Fi)',
                'start' => $festiu->data_final,
                'color' => '#00FF00',
            ];
        }
    
        // Agregar eventos de inicio de unidades formativas (UF)
        foreach ($ufs as $uf) {
            $events[] = [
                'title' => $uf->nom . ' (Inici)',
                'start' => $uf->data_inici,
                'color' => '#FFFF00',
            ];
        }
        foreach ($ufs as $uf) {
            // Calcular la fecha de finalización de la UF sumando el número de semanas a la fecha de inicio de la UF
            $fechaFinUF = $fechaInicioUF->copy()->addWeeks($uf->setmanes);
            
            // Agregar la UF como evento con la fecha de inicio y fin
            $events[] = [
                'title' => $uf->nom . ' (Inici)',
                'start' => $fechaInicioUF->format('Y-m-d'),
                'color' => '#FFFF00',
            ];
            $events[] = [
                'title' => $uf->nom . ' (Fi)',
                'start' => $fechaFinUF->format('Y-m-d'),
                'color' => '#FFFF00',
            ];
            
            // Actualizar la fecha de inicio de la próxima UF sumando el número de semanas de la UF actual
            $fechaInicioUF->addWeeks($uf->setmanes);
        }
         
        // Retornar la vista con los eventos
        return view('showCalendariModul', compact('events', 'cicle','modul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modul $modul)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        //
    }

    private function translateDayOfWeekToEnglish($day)
    {
        switch ($day) {
            case 'Dilluns':
                return 'Monday';
            case 'Dimarts':
                return 'Tuesday';
            case 'Dimecres':
                return 'Wednesday';
            case 'Dijous':
                return 'Thursday';
            case 'Divendres':
                return 'Friday';
            case 'Dissabte':
                return 'Saturday';
            case 'Diumenge':
                return 'Sunday';
            default:
                return null;
        }
    }
}
