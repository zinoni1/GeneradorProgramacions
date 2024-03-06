@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>
        <form action="{{ route('curs.update', $curs->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Datos del curso -->
    <div class="row mb-3" style="background-color: #f7f7f7; padding: 15px;">
        <div class="col-md-4">
            <label for="nom" class="form-label">Nombre del curso</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $curs->nom }}" required>
        </div>
        <div class="col-md-4">
            <label for="data_inici" class="form-label">Fecha de inicio del curso</label>
            <input type="date" class="form-control" id="data_inici" name="data_inici" value="{{ $curs->data_inici }}" required>
        </div>
        <div class="col-md-4">
            <label for="data_final" class="form-label">Fecha final del curso</label>
            <input type="date" class="form-control" id="data_final" name="data_final" value="{{ $curs->data_final }}" required>
        </div>
    </div>

    <!-- Botón de envío para el curso -->
    <button type="submit" class="btn btn-primary mb-3">Actualizar Curso</button>
</form>



    </div>
@endsection
