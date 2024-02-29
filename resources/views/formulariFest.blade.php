@extends('master')

@section('content')

    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>


        <!-- Formulario para agregar festivos -->
        <form action="{{ route('curs.festiu.store',  ['cur' => $curs->id]) }}" method="POST" >
            @csrf
            <div class="row mb-3" style="background-color: #eaeaea; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreFestivo" class="form-label">Nombre del Festivo</label>
                    <input type="text" class="form-control" id="nombreFestivo" name="nombreFestivo" required>
                </div>
                <div class="col-md-4">
                    <label for="tipoFestivo" class="form-label">Tipo de Festivo</label>
                    <select class="form-control" id="tipoFestivo" name="tipoFestivo">
                        <option value="Festius Locals">Dates de festius Locals</option>
                        <option value="Festius Estatals">Dates de festius Estatals</option>
                        <option value="Lliure disposició">Lliure disposició</option>
                        <option value="Períodes de vacances">Períodes de vacances</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="IniciFestivo" class="form-label">Fecha de inicio Festivo</label>
                    <input type="date" class="form-control" id="IniciFestivo" name="IniciFestivo" required>
                </div>
                <div class="col-md-4">
                    <label for="FinalFestivo" class="form-label">Fecha final Festivo</label>
                    <input type="date" class="form-control" id="FinalFestivo" name="FinalFestivo" required>
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
            <li>{{ $festiu->nom }} - Tipus: {{ $festiu->tipus }} - Fecha inicio: {{ $festiu->data_inici }} - Fecha final: {{ $festiu->data_final }}</li>
            @endforeach
        </ul>
        @else
        <p>No se encontraron festivos para este curso.</p>
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
