@extends ('master')

@section('content')
    <div class="container">
        <h1>Formulari de creació de programacions</h1>
        <form action="{{ route('curs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nom">Nom del curs</label>
                <input type="text" class="form-control" id="nom" name="nom" />
            </div>
            <div class="form-group">
                <label for="data_inici">Data d'inici curs</label>
                <input type="date" class="form-control" id="data_inici" name="data_inici" />
            </div>
            <div class="form-group">
                <label for="data_final">Data final curs</label>
                <input type="date" class="form-control" id="data_final" name="data_final" />
            </div>

            <div class="form-group">
                <label for="trimestre">Trimestre</label>
                <input type="text" class="form-control" id="trimestre" name="trimestre" />
            </div>
            <div class="form-group">
                <label for="data_inici_trim">Data d'inici Trimestre</label>
                <input type="date" class="form-control" id="data_inici_trim" name="data_inici_trim" />
            </div>
            <div class="form-group">
                <label for="data_final_trim">Data final Trimestre</label>
                <input type="date" class="form-control" id="data_final_trim" name="data_final_trim" />
            </div>

            <div class="form-group">
                <label for="trimestre">Festius</label>
                <input type="text" class="form-control" id="trimestre" name="trimestre" />
            </div>
            <div class="form-group">
                <label for="data_inici_trim">Data d'inici Festiu</label>
                <input type="date" class="form-control" id="data_inici_trim" name="data_inici_trim" />
            </div>
            <div class="form-group">
                <label for="data_final_trim">Data final Festiu</label>
                <input type="date" class="form-control" id="data_final_trim" name="data_final_trim" />
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
