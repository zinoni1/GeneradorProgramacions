@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Editar Trimestres</h1>

        <!-- Formulario para editar el trimestre -->
        <form method="POST" action="{{ route('trimestre.update', ['id' => $curs->id, 'trimestre_id' => $trimestre->id]) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <input type="hidden" name="trimestres[{{ $trimestre->id }}][id]" value="{{ $trimestre->id }}">
                <div class="col-md-4">
                    <label for="nombreTrimestre{{ $trimestre->id }}" class="form-label">Nombre del Trimestre</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $trimestre->nom }}" required>
                </div>
                <div class="col-md-4">
                    <label for="IniciTrimestre{{ $trimestre->id }}" class="form-label">Fecha de inicio Trimestre</label>
                    <input type="date" class="form-control" id="data_inici" name="data_inici" value="{{ $trimestre->data_inici }}" required>
                </div>
                <div class="col-md-4">
                    <label for="FinalTrimestre{{ $trimestre->id }}" class="form-label">Fecha final Trimestre</label>
                    <input type="date" class="form-control" id="data_final" name="data_final" value="{{ $trimestre->data_final }}" required>
                </div>
            </div>

            <!-- Botón de envío para editar trimestres -->
            <button type="submit" class="btn btn-secondary mb-3">Guardar Cambios</button>
        </form>
    </div>

@endsection

