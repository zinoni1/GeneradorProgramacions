@extends('master')

@section('content')

    <div class="row mt-4">
        @if($moduls->isNotEmpty())
            @foreach($moduls as $modul)
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Generar calendario: {{ $modul->nom }}</h5>
                        </div>
                        <div class="card-body">
                        <a href="{{ route('curs.cicle.modul.show', ['curs' => $curs->id, 'cicle' => $cicle->id, 'modul' => $modul->id]) }}" class="btn btn-primary">Generar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No hay módulos disponibles.</p>
        @endif
    </div>
</div>
<!--Crear botón para crear módulo -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card-body">
                <a href="{{ route('cicle.modul.create', $curs->id) }}" class="btn btn-success">Crear Módul</a>
            </div>
        </div>
    </div>
</div>
@endsection
