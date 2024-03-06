@extends('master')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Formulario de creación de programaciones</h1>

    <!-- Formulario para agregar festivos -->
    <form action="{{ route('curs.festiu.store', ['cur' => $curs->id]) }}" method="POST">
        @csrf

        <div class="row mb-3" style="background-color: #eaeaea; padding: 15px;">
            <div class="col-md-4">
                <label for="nombreFestivo" class="form-label">Nombre del Festivo</label>
                <input type="text" class="form-control @error('nombreFestivo') is-invalid @enderror" id="nombreFestivo" name="nombreFestivo" value="{{ old('nombreFestivo') }}" required>
                @error('nombreFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="tipoFestivo" class="form-label">Tipo de Festivo</label>
                <select class="form-control @error('tipoFestivo') is-invalid @enderror" id="tipoFestivo" name="tipoFestivo" required>
                    <option value="">Selecciona un tipo de festivo</option>
                    <option value="Festius Locals" {{ old('tipoFestivo') == 'Festius Locals' ? 'selected' : '' }}>Dates de festius Locals</option>
                    <option value="Festius Estatals" {{ old('tipoFestivo') == 'Festius Estatals' ? 'selected' : '' }}>Dates de festius Estatals</option>
                    <option value="Lliure disposició" {{ old('tipoFestivo') == 'Lliure disposició' ? 'selected' : '' }}>Lliure disposició</option>
                    <option value="Períodes de vacances" {{ old('tipoFestivo') == 'Períodes de vacances' ? 'selected' : '' }}>Períodes de vacances</option>
                </select>
                @error('tipoFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="IniciFestivo" class="form-label">Fecha de inicio Festivo</label>
                <input type="date" class="form-control @error('IniciFestivo') is-invalid @enderror" id="IniciFestivo" name="IniciFestivo" value="{{ old('IniciFestivo') }}" required>
                @error('IniciFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="FinalFestivo" class="form-label">Fecha final Festivo</label>
                <input type="date" class="form-control @error('FinalFestivo') is-invalid @enderror" id="FinalFestivo" name="FinalFestivo" value="{{ old('FinalFestivo') }}" required>
                @error('FinalFestivo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <!-- Botón de envío para agregar festivo -->
        <button type="submit" class="btn btn-secondary">Agregar Festivo</button>
        <a href="{{ route('curs.index') }}" class="btn btn-danger">Salir</a>
    </form>
</div>

<div class="festivo-content mt-4">
    <h2>Festivos del curso actual</h2>
    @if($festius->isNotEmpty())
        <ul>
            @foreach($festius as $festiu)
                <li>{{ $festiu->nom }} - Tipus: {{ $festiu->tipus }} - Fecha inicio: {{ $festiu->data_inici }} - Fecha final: {{ $festiu->data_final }}
                    <form action="{{ route('curs.festiu.destroy', ['cur' => $curs->id, 'festiu' => $festiu->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No se encontraron festivos para este curso.</p>
    @endif
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
