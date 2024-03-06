@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulari de creació de programacions</h1>

        <form action="{{ route('curs.uf.create', ['modulId' => $modul->id]) }}" method="POST">
            @csrf
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreUf" class="form-label">Nom de la Unitat Formativa</label>
                    <input type="text" class="form-control" id="nombreUf" name="nombreUf" placeholder="Uf" required>
                </div>
                <div class="col-md-4">
                    <label for="nSetmanes" class="form-label">Nombre de setmanes</label>
                    <input type="text" class="form-control" id="nSetmanes" name="nSetmanes" required>
                </div>
                <div class="col-md-4">
                    <label for="ordre" class="form-label">Ordre</label>
                    <input type="number" class="form-control" id="ordre" name="ordre" required>
                </div>
            </div>
            <!-- Botó d'enviament per afegir Unitat Formativa -->
            <button type="submit" class="btn btn-secondary mb-3">Afegir Unitat Formativa</button>
            <a href="{{ route('curs.modul.create', ['cur' => $modul->cicle->curs_id, 'modul' => $modul->id]) }}" class="btn btn-danger">Sortir</a>
        </form>
    </div>
@endsection
