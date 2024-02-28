@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>

        <!-- Formulario para agregar trimestres -->
        <form id="trimestreForm" action="{{ route('trimestre.store') }}" method="POST">
    @csrf
    <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
        <div class="col-md-4">
            <label for="nombreTrimestre" class="form-label">Nombre del Trimestre</label>
            <input type="text" class="form-control" id="nombreTrimestre" name="nombreTrimestre" placeholder="Trimestre" required>
        </div>
        <div class="col-md-4">
            <label for="IniciTrimestre" class="form-label">Fecha de inicio Trimestre</label>
            <input type="date" class="form-control" id="IniciTrimestre" name="IniciTrimestre" required>
        </div>
        <div class="col-md-4">
            <label for="FinalTrimestre" class="form-label">Fecha final Trimestre</label>
            <input type="date" class="form-control" id="FinalTrimestre" name="FinalTrimestre" required>
        </div>
    </div>
    <!-- Botón de envío para agregar trimestre -->
    <button type="submit" class="btn btn-secondary mb-3">Agregar Trimestre</button>
</form>

        <!-- Formulario para agregar cursos -->
        <form id="cursoForm">
            <!-- Aquí puedes añadir campos para la creación de cursos -->
        </form>

        <!-- Aquí puedes mostrar los trimestres creados debajo del formulario de cursos -->
        <div id="trimestresCreados">
            <!-- Aquí se mostrarán los trimestres creados dinámicamente -->
        </div>
    </div>
    <div class="festivo-content mt-4">
    <h2>Trimestres del curso actual</h2>
    @if($trimestres->isNotEmpty())
    <ul>
        @foreach($trimestres as $trimestre)
        <li>{{ $trimestre->nom }} - Fecha inicio: {{ $trimestre->data_inici }} - Fecha final: {{ $trimestre->data_final }}</li>
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
