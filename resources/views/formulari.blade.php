@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulario de creación de programaciones</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('curs.store') }}" method="POST">
        @csrf

        <!-- Datos del curso -->
        <div class="row mb-3" style="background-color: #f7f7f7; padding: 15px;">
            <div class="col-md-4">
                <label for="nom" class="form-label">Nombre del curso</label>
                <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
            </div>
            <div class="col-md-4">
                <label for="data_inici" class="form-label">Fecha de inicio del curso</label>
                <input type="date" class="form-control" id="data_inici" name="data_inici" required value="{{ old('data_inici') }}" min="2020-01-01" placeholder="Año-Mes-Día (mín. 2020)">
                @error('data_inici')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="data_final" class="form-label">Fecha final del curso</label>
                <input type="date" class="form-control" id="data_final" name="data_final" required value="{{ old('data_final') }}">
            </div>
        </div>

        <!-- Botón de envío para el curso -->
        <button type="submit" class="btn btn-primary mb-3">Crear Curso</button>
    </form>
</div>


@endsection

<style>
    .festivo-content {
        margin-top: 10px;
    }
    #toggleAllBtn {
        display: none;
        background-color: #00FFFF;
    }
    #toggleAllTrimestresBtn {
        display: none;
        background-color: #00FFFF;
    }
</style>
