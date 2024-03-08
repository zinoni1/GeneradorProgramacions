@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulari de creació de programacions</h1>

    <!-- Formulario para añadir festivos -->
    <form action="{{ route('curs.festiu.store', ['cur' => $curs->id]) }}" method="POST">
        @csrf

        <div class="row mb-3" style="background-color: #eaeaea; padding: 15px;">
            <div class="col-md-4">
                <label for="nombreFestivo" class="form-label">Nom del Festiu</label>
                <input type="text" class="form-control @error('nombreFestivo') is-invalid @enderror" id="nombreFestivo" name="nombreFestivo" value="{{ old('nombreFestivo') }}" required>
                @error('nombreFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="tipoFestivo" class="form-label">Tipus de Festiu</label>
                <select class="form-control @error('tipoFestivo') is-invalid @enderror" id="tipoFestivo" name="tipoFestivo" required>
                    <option value="">Selecciona un tipus de festiu</option>
                    <option value="Festius Locals" {{ old('tipoFestivo') == 'Festius Locals' ? 'selected' : '' }}>Dates de festius locals</option>
                    <option value="Festius Estatals" {{ old('tipoFestivo') == 'Festius Estatals' ? 'selected' : '' }}>Dates de festius estatals</option>
                    <option value="Lliure disposició" {{ old('tipoFestivo') == 'Lliure disposició' ? 'selected' : '' }}>Lliure disposició</option>
                    <option value="Períodes de vacances" {{ old('tipoFestivo') == 'Períodes de vacances' ? 'selected' : '' }}>Períodes de vacances</option>
                </select>
                @error('tipoFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="IniciFestivo" class="form-label">Data d'inici del Festiu</label>
                <input type="date" class="form-control @error('IniciFestivo') is-invalid @enderror" id="IniciFestivo" name="IniciFestivo" value="{{ old('IniciFestivo') }}" required>
                @error('IniciFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="FinalFestivo" class="form-label">Data final del Festiu</label>
                <input type="date" class="form-control @error('FinalFestivo') is-invalid @enderror" id="FinalFestivo" name="FinalFestivo" value="{{ old('FinalFestivo') }}" required>
                @error('FinalFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <!-- Botón de envío para añadir festivo -->
                <button type="submit" class="btn btn-secondary">Afegir Festiu</button>
                <a href="{{ route('curs.index') }}" class="btn btn-danger">Sortir</a>
            </div>
        </div>
    </form>

    <!-- Aquí puedes mostrar los festivos creados debajo del formulario -->
    <div class="festivo-content mt-4" style="background-color: #f7f7f7; padding: 15px;">
        <h2>Festius del curs actual</h2>
        @if($festius->isNotEmpty())
            <div class="list-group">
                @foreach($festius as $festiu)
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>{{ $festiu->nom }} - Tipus: {{ $festiu->tipus }} - Data d'inici: {{ $festiu->data_inici }} - Data final: {{ $festiu->data_final }}</span>
                        <form action="{{ route('curs.festiu.destroy', ['cur' => $curs->id, 'festiu' => $festiu->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p>No s'han trobat festius per aquest curs.</p>
        @endif
    </div>
</div>

@endsection

<style>
    .festivo-content {
        margin-top: 10px;
    }

    #toggleAllBtn {
        display: none;
        background-color: #00FFFF;
    }

    #toggleAllTrimestresBtn {
        display: none;
        background-color: #00FFFF;
    }
</style>
