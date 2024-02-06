@extends ('master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                <label for="nombreFestivo">Nombre del Festivo</label>
                <input type="text" class="form-control" id="nombreFestivo" name="nombreFestivo" />
            </div>
            <div class="form-group">
                <label for="fechaInicioFestivo">Fecha de inicio Festivo</label>
                <input type="date" class="form-control" id="fechaInicioFestivo" name="fechaInicioFestivo" />
            </div>
            <div class="form-group">
                <label for="fechaFinalFestivo">Fecha final Festivo</label>
                <input type="date" class="form-control" id="fechaFinalFestivo" name="fechaFinalFestivo" />
            </div>
            <button type="button" id="addFestivo" class="btn btn-secondary">Agregar Festivo</button>
            <button type="button" id="toggleAllBtn" class="btn btn-secondary">Mostrar/Esconder Todos</button>

            <div id="festivosContainer"></div>


            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
@endsection
<script>
    $(document).ready(function(){

        $("#addFestivo").click(function () {

            var newFestivo = $('<div>', {class: 'festivo'});
            newFestivo.append('<h3>' +$("#nombreFestivo").val()  + '</h3>');
            newFestivo.append('<p><strong>Fecha de inicio:</strong> ' + $("#fechaInicioFestivo").val() + '</p>');
            newFestivo.append('<p><strong>Fecha final:</strong> ' + $("#fechaFinalFestivo").val() + '</p>');

            $("#festivosContainer").append(newFestivo);

            if (!$("#toggleAllBtn").hasClass("active")) {
                $(".festivo").slideDown();
                $("#toggleAllBtn").addClass("active").text("-");
            }
            if ($("#festivosContainer").children().length === 1) {
                $("#toggleAllBtn").show();
            }
        });

        $("#toggleAllBtn").click(function() {
            $(".festivo").slideToggle();
            $(this).toggleClass("active");
            if ($(this).hasClass("active")) {
                $(this).text("-");
            } else {
                $(this).text("+");
            }
        });
    });
</script>

<style>
    .festivo-content {
        margin-top: 10px;
    }
    #toggleAllBtn {
        display: none;
        background-color: #00FFFF;
    }
</style>
