@extends('master')

@section('content')

    <div class="row mp-4">
        @if($cicles->isNotEmpty())
            @foreach($cicles as $cicle)
                <div class="col-md-4 m-5">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Cicle: {{ $cicle->nom }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Corregir la llamada a route -->
                            <a href="{{ route('curs.cicle.show', ['cursId' => $curs->id, 'cicleId' => $cicle->id]) }}" class="btn btn-primary">Entrar a módulos</a>
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
<div class="container m-4">
    <div class="row">
        <div class="col-md-4 m-3">
                <div class="card-body">
                    <a href="{{ route('curs.cicle.create', $curs->id) }}" class="btn btn-success">Crear Cicle</a>
                </div>
                <div class="card-body mt-2">
                    <a href="{{ route('curs.show', $curs->id) }}" class="btn btn-danger">Tornar</a>
                </div>
        </div>
    </div>
@endsection
