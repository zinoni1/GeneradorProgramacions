@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Formulari de creació de programacions</h1>
        <form action="{{ route('curs.update', $curs->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Dades del curs -->
    <div class="row mb-3" style="background-color: #f7f7f7; padding: 15px;">
        <div class="col-md-4">
            <label for="nom" class="form-label">Nom del curs</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $curs->nom }}" required>
        </div>
        <div class="col-md-4">
            <label for="data_inici" class="form-label">Data d'inici del curs</label>
            <input type="date" class="form-control" id="data_inici" name="data_inici" value="{{ $curs->data_inici }}" required>
        </div>
        <div class="col-md-4">
            <label for="data_final" class="form-label">Data final del curs</label>
            <input type="date" class="form-control" id="data_final" name="data_final" value="{{ $curs->data_final }}" required>
        </div>
    </div>

    <!-- Botó d'enviament per al curs -->
    <button type="submit" class="btn btn-primary mb-3">Actualitzar Curs</button>
</form>

    </div>
@endsection
