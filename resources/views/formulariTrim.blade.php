@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>

        <!-- Formulario para agregar trimestres -->
        <form id="trimestreForm" action="{{ route('curs.trimestre.store', ['cur' => $curs->id]) }}" method="POST">
            @csrf
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreTrimestre" class="form-label">Nombre del Trimestre</label>
                    <input type="text" class="form-control @error('nombreTrimestre') is-invalid @enderror" id="nombreTrimestre" name="nombreTrimestre" placeholder="Trimestre" value="{{ old('nombreTrimestre') }}" required>
                    @error('nombreTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="IniciTrimestre" class="form-label">Fecha de inicio Trimestre</label>
                    <input type="date" class="form-control @error('IniciTrimestre') is-invalid @enderror" id="IniciTrimestre" name="IniciTrimestre" value="{{ old('IniciTrimestre') }}" required>
                    @error('IniciTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="FinalTrimestre" class="form-label">Fecha final Trimestre</label>
                    <input type="date" class="form-control @error('FinalTrimestre') is-invalid @enderror" id="FinalTrimestre" name="FinalTrimestre" value="{{ old('FinalTrimestre') }}" required>
                    @error('FinalTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Botón de envío para agregar trimestre -->
            <button type="submit" class="btn btn-secondary mb-3">Agregar Trimestre</button>
        </form>

        <!-- Aquí puedes mostrar los trimestres creados debajo del formulario de cursos -->
        <div class="festivo-content mt-4">
    <h2>Trimestres del curso actual</h2>
    @if($trimestres->isNotEmpty())
        <ul>
            @foreach($trimestres as $trimestre)
                <li>
                    {{ $trimestre->nom }} - Fecha inicio: {{ $trimestre->data_inici }} - Fecha final: {{ $trimestre->data_final }}
                    <form action="{{ route('curs.trimestre.destroy', ['cur' => $curs->id, 'trimestre' => $trimestre->id]) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>

                </li>
            @endforeach
        </ul>
    @else
        <p>No se encontraron trimestres para este curso.</p>
    @endif
</div>
@endsection

@section('scripts')
    <script>
        // Evitar que la página se recargue al enviar el formulario de trimestres
        document.getElementById('trimestreForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // Aquí puedes agregar el código para enviar el formulario mediante AJAX si lo deseas
        });
    </script>
@endsection
