@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>

        <!-- Formulario para agregar trimestres -->
        <form id="modulForm" action="{{ route('curs.modul.store',  ['cur' => $curs->id]) }}" method="POST">
            
    @csrf
    <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
        <div class="col-md-4">
            <label for="nombreModul" class="form-label">Nom del Modul</label>
            <input type="text" class="form-control" id="nombreModul" name="nombreModul" placeholder="Modul" required>
        </div>

    </div>
    <button type="submit" class="btn btn-secondary mb-3">Agregar Modul</button>
</form>

    
    </div>

@endsection