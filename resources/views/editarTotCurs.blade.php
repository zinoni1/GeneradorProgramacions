@extends('master')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Editar Curs: {{$curs->nom}}</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('curs.edit', $curs->id) }}" class="btn btn-primary">Editar Curs</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @if($trimestres->isNotEmpty())
            @foreach($trimestres as $trimestre)
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Editar Trimestre: {{ $trimestre->nom }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('curs.trimestre.edit', ['cur' => $curs->id, 'trimestre' => $trimestre->id]) }}" class="btn btn-primary">Editar Trimestre</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No hi ha trimestres disponibles.</p>
        @endif
    </div>

    <div class="row mt-4">
        @if($festivos->isNotEmpty())
            @foreach($festivos as $festivo)
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Editar Festiu: {{ $festivo->nom }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('curs.festiu.edit', ['cur' => $curs->id, 'festiu' => $festivo->id]) }}" class="btn btn-primary">Editar Festiu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No hi ha festius disponibles.</p>
        @endif
    </div>
</div>
<!--Crear botó per crear festiu -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
                <div class="card-body">
                    <a href="{{ route('curs.festiu.create', $curs->id) }}" class="btn btn-success">Crear Festiu</a>
                </div>
                <div class="card-body mt-2">
                    <a href="{{ route('curs.show', $curs->id) }}" class="btn btn-danger">Tornar</a>
                </div>
        </div>
    </div>
</div>
@endsection
