@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulari de creació de programacions</h1>

    <!-- Formulari per afegir mòduls -->
    <form id="modulForm" action="{{ route('cicle.modul.store', ['cicle' => $cicle->id]) }}" method="POST">
        @csrf
        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3" style="background-color: #f2f2f2; padding: 15px;">
                    <label for="nombreModul" class="form-label">Nom del Mòdul</label>
                    <input type="text" class="form-control" id="nombreModul" name="nombreModul" placeholder="Mòdul" required>
                </div>
                <button type="submit" class="btn btn-secondary btn-block">Afegir Mòdul</button>
                <a href="{{ route('curs.index') }}" class="btn btn-danger btn-block">Sortir</a>
            </div>
        </div>
    </form>
</div>


@endsection
