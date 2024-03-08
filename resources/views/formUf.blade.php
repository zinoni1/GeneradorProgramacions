@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulari de creació de programacions</h1>

        <!-- Formulario para añadir UF -->
        <form id="ufForm" action="{{ route('modul.uf.store', ['modul' => $modul->id]) }}" method="POST">
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
            <!-- Botón de envío para añadir UF -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Afegir Unitat Formativa</button>
                    <a href="{{ route('cicle.modul.create', ['cicle' => $cicle->id]) }}" class="btn btn-danger">Sortir</a>
                </div>
            </div>
        </form>

        <!-- Mostrar las UF creadas debajo del formulario -->
        <div class="uf-content mt-4" style="background-color: #f7f7f7; padding: 15px;">
            <h2>Unitats Formatives creades</h2>
            @if($modul->ufs->isNotEmpty())
                <div class="list-group">
                    @foreach($modul->ufs as $uf)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $uf->nom }} - Setmanes: {{ $uf->setmanes }} - Ordre: {{ $uf->ordre }}</span>
                            <form action="{{ route('modul.uf.destroy', ['modul' => $modul->id, 'uf' => $uf->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No s'han trobat Unitats Formatives per aquest mòdul.</p>
            @endif
        </div>
    </div>
@endsection
