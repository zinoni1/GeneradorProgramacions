@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>
        <form action="{{ route('curs.cicle.store', ['cur' => $curs->id]) }}" method="POST">


            @csrf

            <!-- Información del ciclo -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="ciclo" class="form-label">Nombre del Ciclo</label>
                    <input type="text" class="form-control" id="ciclo" name="ciclo" required>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
