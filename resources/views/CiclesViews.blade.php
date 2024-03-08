@extends('master')

@section('content')

<div class="container mt-4">
    <div class="row">
        @if($cicles->isNotEmpty())
            @foreach($cicles as $cicle)
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Cicle: {{ $cicle->nom }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('curs.cicle.show', ['cursId' => $curs->id, 'cicleId' => $cicle->id]) }}" class="btn btn-primary btn-block">Entrar a mòduls</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    No hi ha mòduls disponibles.
                </div>
            </div>
        @endif
    </div>
</div>

<!--Crear botón para crear cicle -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('curs.cicle.create', $curs->id) }}" class="btn btn-success btn-block">Crear Cicle</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botón para volver -->
<div class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <a href="{{ route('curs.show', $curs->id) }}" class="btn btn-danger btn-block">Tornar</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
