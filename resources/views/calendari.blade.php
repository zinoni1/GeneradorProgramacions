@extends('master')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendari Curs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

@foreach($cursos as $curs)
    <div class="container">
        <h2>{{ $curs->nom }}</h2>
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Semana</th>
                            <th>Data</th>
                            <th>Dia</th>
                            <th>Tasca</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $inicio = new DateTime($curs->data_inici);
                            $final = new DateTime($curs->data_final);
                            $diasSemana = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];
                            $trimestres = App\Models\Trimestre::where('data_inici', '<=', $final)->where('data_final', '>=', $inicio)->get();
                            $festivos = App\Models\Festiu::where('data_inici', '>=', $inicio)->where('data_final', '<=', $final)->get();
                            $contadorSemana = 0;
                            $rowspan = 0;
                        @endphp
                        @while ($inicio <= $final)
                            @php
                                // Obtener el día de la semana
                                $diaSemana = $inicio->format('N');
                                // Calcular rowspan y número de semana
                                if ($inicio->format('Y-m-d') == $curs->data_inici ||$diaSemana == 1 ) {
                                    // Calcula los días restantes en la semana
                                    $rowspan = 8 - $diaSemana ;
                                    $contadorSemana++;
                                }
                            @endphp
                            <tr>

                                @if ($inicio->format('Y-m-d') == $curs->data_inici  ||$diaSemana == 1 )
                                    <td rowspan="{{ $rowspan }}">{{ $contadorSemana }}</td>
                                @endif
                                <td>{{ $inicio->format('d/m/Y') }}</td>
                                <td>{{ $diasSemana[$inicio->format('l')] }}</td>
                                <td>
                                    @php
                                        $currentDate = $inicio->format('Y-m-d');
                                        $inicioCurso = $curs->data_inici;
                                        $finCurso = $curs->data_final;
                                        $trimestreInicio = null;
                                        $trimestreFin = null;
                                        $festivo = null;
                                        if ($trimestres) {
                                            $trimestreInicio = $trimestres->where('data_inici', $currentDate)->first();
                                            $trimestreFin = $trimestres->where('data_final', $currentDate)->first();
                                        }
                                        if ($festivos) {
                                            $festivo = $festivos->where('data_inici', '<=', $currentDate)->where('data_final', '>=', $currentDate)->first();
                                        }
                                    @endphp
                                    @if ($festivo)
                                        {{ $festivo->nom }} - {{ $festivo->tipus }}<br>
                                    @elseif ($trimestreInicio)
                                        {{ $trimestreInicio->nom }} - Inicio de Trimestre<br>
                                    @elseif ($trimestreFin)
                                        {{ $trimestreFin->nom }} - Fin de Trimestre<br>
                                    @elseif ($currentDate == $inicioCurso)
                                        Inicio de Curso<br>
                                    @elseif ($currentDate == $finCurso)
                                        Fin de Curso<br>
                                    @else
                                        <br>
                                    @endif
                                </td>
                            </tr>
                            @php
                                $inicio->add(new DateInterval('P1D'));
                            @endphp
                        @endwhile
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach

</body>
</html>
