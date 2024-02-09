@extends('master')

@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendario Anual</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Estilos para líneas horizontales y verticales */
    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .table-bordered tr:last-child td {
        border-bottom: 1px solid #dee2e6; /* Línea horizontal en la última fila */
    }

    .table-bordered td:last-child {
        border-right: 1px solid #dee2e6; /* Línea vertical en la última columna */
    }
</style>
</head>
<body>

@foreach($cursos as $curs)
    <div class="container">
        <h2>{{ $curs->nom }}</h2> <!-- Aquí mostramos el nombre del curso -->
        <div class="row">
            <div class="col">
                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Semana</th>
                            <th>Data</th>
                            <th>Dia</th>
                            <th>Tasca</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Iterar sobre los cursos -->
                        @php $contadorSemana = 1; @endphp
                        @php
                            $inicio = new DateTime($curs->data_inici);
                            $final = new DateTime($curs->data_final);
                            $diasCurso = $final->diff($inicio)->days;
                            $diasSemana = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'];
                            $trimestres = App\Models\Trimestre::where('data_inici', '<=', $final)->where('data_final', '>=', $inicio)->get();
                            $festivos = App\Models\Festiu::where('data_inici', '>=', $inicio)->where('data_final', '<=', $final)->get();
                        @endphp
                        @php $inicioSemana = clone $inicio; @endphp <!-- Clonamos la fecha de inicio de curso para mantenerla inmutable -->
                        @for ($i = 0; $i <= $diasCurso; $i += 7)
                        <tr>
                            <td>{{ $contadorSemana }}</td>
                            <td>
                                @for ($j = 0; $j < 7 && $i + $j <= $diasCurso; $j++)
                                    {{ $inicioSemana->format('d/m/Y') }}<br>
                                    @php $inicioSemana->add(new DateInterval('P1D')); @endphp
                                @endfor
                            </td>
                            <td>
                                @php $inicioDia = clone $inicio; @endphp
                                @for ($j = 0; $j < 7 && $i + $j <= $diasCurso; $j++)
                                    {{ $diasSemana[$inicioDia->format('l')] }}<br>
                                    @php $inicioDia->add(new DateInterval('P1D')); @endphp
                                @endfor
                            </td>
                            <td>
                                @for ($j = 0; $j < 7 && $i + $j <= $diasCurso; $j++)
                                    {{-- Verificar si hay festivo o inicio/fin de trimestre --}}
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
                                        {{-- Deja la celda de tarea vacía si no hay eventos programados --}}
                                        <br>
                                    @endif
                                    @php $inicio->add(new DateInterval('P1D')); @endphp
                                @endfor
                            </td>
                        </tr>
                        @php $contadorSemana++; @endphp
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endforeach

</body>
</html>

@endsection
