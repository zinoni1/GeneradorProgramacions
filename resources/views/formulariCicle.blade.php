@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulari de creació de programacions</h1>
        <form action="{{ route('curs.cicle.store', ['cur' => $curs->id]) }}" method="POST">


            @csrf

            <!-- Informació del cicle -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="ciclo" class="form-label">Nom del Cicle</label>
                    <input type="text" class="form-control" id="ciclo" name="ciclo" required>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
