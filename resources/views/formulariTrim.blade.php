@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulari de creació de programacions</h1>

        <!-- Formulari per afegir trimestres -->
        <form id="trimestreForm" action="{{ route('curs.trimestre.store', ['cur' => $curs->id]) }}" method="POST">
            @csrf
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreTrimestre" class="form-label">Nom del Trimestre</label>
                    <input type="text" class="form-control @error('nombreTrimestre') is-invalid @enderror" id="nombreTrimestre" name="nombreTrimestre" placeholder="Trimestre" value="{{ old('nombreTrimestre') }}" required>
                    @error('nombreTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="IniciTrimestre" class="form-label">Data d'inici del Trimestre</label>
                    <input type="date" class="form-control @error('IniciTrimestre') is-invalid @enderror" id="IniciTrimestre" name="IniciTrimestre" value="{{ old('IniciTrimestre') }}" required>
                    @error('IniciTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="FinalTrimestre" class="form-label">Data final del Trimestre</label>
                    <input type="date" class="form-control @error('FinalTrimestre') is-invalid @enderror" id="FinalTrimestre" name="FinalTrimestre" value="{{ old('FinalTrimestre') }}" required>
                    @error('FinalTrimestre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Botó d'enviament per afegir trimestre -->
            <button type="submit" class="btn btn-secondary mb-3">Afegir Trimestre</button>
        </form>

        <!-- Aquí pots mostrar els trimestres creats sota del formulari de cursos -->
        <div class="festivo-content mt-4">
    <h2>Trimestres del curs actual</h2>
    @if($trimestres->isNotEmpty())
        <ul>
            @foreach($trimestres as $trimestre)
                <li>
                    {{ $trimestre->nom }} - Data d'inici: {{ $trimestre->data_inici }} - Data final: {{ $trimestre->data_final }}
                    <form action="{{ route('curs.trimestre.destroy', ['cur' => $curs->id, 'trimestre' => $trimestre->id]) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
</form>

                </li>
            @endforeach
        </ul>
    @else
        <p>No s'han trobat trimestres per aquest curs.</p>
    @endif
</div>
@endsection

@section('scripts')
    <script>
        // Evitar que la pàgina es recarregui en enviar el formulari de trimestres
        document.getElementById('trimestreForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // Aquí pots afegir el codi per enviar el formulari mitjançant AJAX si ho desitges
        });
    </script>
@endsection
