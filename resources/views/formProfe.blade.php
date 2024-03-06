@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulari d'Assignació de Professor</h1>

    <form id="profesorForm" action="{{ route('cicle.numdies.store', ['cicle' => $cicle->id]) }}" method="POST">


        @csrf
        <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
            <div class="col-md-4">
                <label for="cicle_id" class="form-label">Cicle</label>
                <select class="form-select" id="cicle_id" name="cicle_id" required>
                    <option value="">Seleccioneu un cicle</option>
                    @foreach($cicles as $cicle)
                        <option value="{{ $cicle->id }}">{{ $cicle->nom }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-4">
                <label for="dia" class="form-label">Dia de la Setmana</label>
                <input type="text" class="form-control" id="dia" name="dia" placeholder="Dia de la setmana" required>
            </div>
            <div class="col-md-4">
                <label for="horas" class="form-label">Número d'hores</label>
                <input type="number" class="form-control" id="horas" name="horas" placeholder="Número d'hores" required>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary mb-3">Afegir Assignació</button>
    </form>

</div>

@endsection
