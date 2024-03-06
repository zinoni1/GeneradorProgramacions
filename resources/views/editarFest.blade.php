@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Editar Festivo</h1>

        <!-- Formulario para editar el festivo -->
        <form method="POST" action="{{ route('festiu.update', ['id' => $curs->id, 'festiu_id' => $festiu->id]) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <input type="hidden" name="festius[{{ $festiu->id }}][id]" value="{{ $festiu->id }}">
                <div class="col-md-4">
                    <label for="nombreFestiu{{ $festiu->id }}" class="form-label">Nombre del Festivo</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $festiu->nom }}" required>
                </div>
                <div class="col-md-4">
                    <label for="IniciFestiu{{ $festiu->id }}" class="form-label">Fecha de inicio del Festivo</label>
                    <input type="date" class="form-control" id="data_inici" name="data_inici" value="{{ $festiu->data_inici }}" required>
                </div>
                <div class="col-md-4">
                    <label for="FinalFestiu{{ $festiu->id }}" class="form-label">Fecha final del Festivo</label>
                    <input type="date" class="form-control" id="data_final" name="data_final" value="{{ $festiu->data_final }}" required>
                </div>
            </div>

            <!-- Botón de envío para editar festivos -->
            <button type="submit" class="btn btn-secondary mb-3">Guardar Cambios</button>
        </form>
    </div>

@endsection
