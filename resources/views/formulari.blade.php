@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulari de creació de programacions</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('curs.store') }}" method="POST">
        @csrf

        <!-- Dades del curs -->
        <div class="row mb-3" style="background-color: #f7f7f7; padding: 15px;">
            <div class="col-md-4">
                <label for="nom" class="form-label">Nom del curs</label>
                <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
            </div>
            <div class="col-md-4">
                <label for="data_inici" class="form-label">Data d'inici del curs</label>
                <input type="date" class="form-control" id="data_inici" name="data_inici" required value="{{ old('data_inici') }}" min="2020-01-01" placeholder="Any-Mes-Dia (mín. 2020)">
                @error('data_inici')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="data_final" class="form-label">Data final del curs</label>
                <input type="date" class="form-control" id="data_final" name="data_final" required value="{{ old('data_final') }}">
            </div>
        </div>

        <!-- Botó d'enviament per al curs -->
        <button type="submit" class="btn btn-primary mb-3">Crear Curs</button>
    </form>
</div>


@endsection
