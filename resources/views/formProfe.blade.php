@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulario de Asignación de Profesor</h1>

    <form id="profesorForm" action="{{ route('cicle.numdies.store', ['cicle' => $cicle->id]) }}" method="POST">


        @csrf
        <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
            <div class="col-md-4">
                <label for="cicle_id" class="form-label">Ciclo</label>
                <select class="form-select" id="cicle_id" name="cicle_id" required>
    <option value="">Seleccione un ciclo</option>
    @foreach($cicles as $cicle)
        <option value="{{ $cicle->id }}">{{ $cicle->nom }}</option>
    @endforeach
</select>

            </div>
            <div class="col-md-4">
                <label for="dia" class="form-label">Dia de la Setmana</label>
                <input type="text" class="form-control" id="dia" name="dia" placeholder="Dia de la semana" required>
            </div>
            <div class="col-md-4">
                <label for="horas" class="form-label">Número de horas</label>
                <input type="number" class="form-control" id="horas" name="horas" placeholder="Número de horas" required>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary mb-3">Agregar Asignación</button>
    </form>

</div>

@endsection 