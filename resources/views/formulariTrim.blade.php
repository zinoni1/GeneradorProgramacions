@extends('master')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Formulari de creació de programacions</h1>

    <!-- Formulario para añadir trimestres -->
    <form id="trimestreForm" action="{{ route('curs.trimestre.store', ['cur' => $curs->id]) }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>
                            <label for="nomTrimestre" class="form-label">Nom del Trimestre</label>
                            <input type="text" class="form-control @error('nomTrimestre') is-invalid @enderror" id="nomTrimestre" name="nomTrimestre" placeholder="Trimestre" value="{{ old('nomTrimestre') }}" required>
                            @error('nomTrimestre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <label for="IniciTrimestre" class="form-label">Data d'inici del Trimestre</label>
                            <input type="date" class="form-control @error('IniciTrimestre') is-invalid @enderror" id="IniciTrimestre" name="IniciTrimestre" value="{{ old('IniciTrimestre') }}" required>
                            @error('IniciTrimestre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>
                            <label for="FinalTrimestre" class="form-label">Data final del Trimestre</label>
                            <input type="date" class="form-control @error('FinalTrimestre') is-invalid @enderror" id="FinalTrimestre" name="FinalTrimestre" value="{{ old('FinalTrimestre') }}" required>
                            @error('FinalTrimestre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Botón de envío para añadir trimestre -->
        <button type="submit" class="btn btn-secondary mb-3">Afegir Trimestre</button>
    </form>
    <!-- Aquí puedes mostrar los trimestres creados debajo del formulario de cursos -->
    <div class="festivo-content mt-4" style="background-color: #f7f7f7; padding: 15px;">
        <h2>Trimestres del curs actual</h2>
        @if($trimestres->isNotEmpty())
        <div class="list-group">
            @foreach($trimestres as $trimestre)
            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <span>{{ $trimestre->nom }} - Data d'inici: {{ $trimestre->data_inici }} - Data final: {{ $trimestre->data_final }}</span>
                <form action="{{ route('curs.trimestre.destroy', ['cur' => $curs->id, 'trimestre' => $trimestre->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <p>No s'han trobat trimestres per aquest curs.</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Evitar que la página se recargue al enviar el formulario de trimestres
    document.getElementById('trimestreForm').addEventListener('submit', function(event) {
        event.preventDefault();
        // Aquí puedes añadir el código para enviar el formulario mediante AJAX si lo deseas
    });
</script>
@endsection
