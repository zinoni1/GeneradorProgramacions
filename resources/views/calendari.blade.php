@extends('master')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Calendari de Cursos</h2>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h3 class="mb-3">{{ $curs->nom }}</h3>
                <a href="{{ route('curs.editTot', $curs->id) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('cicle.numdies.create', $curs->id) }}" class="btn btn-primary">Assignació hores moduls</a>
                <form action="{{ route('curs.destroy', $curs->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                <a href="{{ route('curs.showCicles', $curs->id) }}" class="btn btn-success">Cicles</a>
                <a href="{{ route('curs.index', $curs->id) }}" class="btn btn-info">Tornar</a>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Setmana</th>
                                <th>Data</th>
                                <th>Dia</th>
                                <th>Tasca</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $inicio = new DateTime($curs->data_inici);
                            $final = new DateTime($curs->data_final);
                            $diasSemana = ['Monday' => 'Dilluns', 'Tuesday' => 'Dimarts', 'Wednesday' => 'Dimecres', 'Thursday' => 'Dijous', 'Friday' => 'Divendres', 'Saturday' => 'Dissabte', 'Sunday' => 'Diumenge'];
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
                            if ($inicio->format('Y-m-d') == $curs->data_inici || $diaSemana == 1) {
                            // Calcula los días restantes en la semana
                            $rowspan = 8 - $diaSemana ;
                            $contadorSemana++;
                            }
                            @endphp
                            <tr>
                                @if ($inicio->format('Y-m-d') == $curs->data_inici || $diaSemana == 1)
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
                                    {{ $festivo->nom }} - {{ $festivo->tipus }}
                                    @elseif ($trimestreInicio)
                                    {{ $trimestreInicio->nom }} - Inici de Trimestre
                                    @elseif ($trimestreFin)
                                    {{ $trimestreFin->nom }} - Fi de Trimestre
                                    @elseif ($currentDate == $inicioCurso)
                                    Inici de Curs
                                    @elseif ($currentDate == $finCurso)
                                    Fi de Curs
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
        <div class="card-footer">
            <form action="{{ route('curs.export') }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary">Exportar a Excel</button>
            </form>
        </div>
    </div>
</div>
@endsection
