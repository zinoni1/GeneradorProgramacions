@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>
        <form action="{{ route('curs.store') }}" method="POST">
            @csrf

            <!-- Datos del curso -->
            <div class="row mb-3" style="background-color: #f7f7f7; padding: 15px;">
                <div class="col-md-4">
                    <label for="nom" class="form-label">Nombre del curso</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="col-md-4">
                    <label for="data_inici" class="form-label">Fecha de inicio del curso</label>
                    <input type="date" class="form-control" id="data_inici" name="data_inici" required>
                </div>
                <div class="col-md-4">
                    <label for="data_final" class="form-label">Fecha final del curso</label>
                    <input type="date" class="form-control" id="data_final" name="data_final" required>
                </div>
            </div>

            <!-- Trimestres -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="numTrimestre" class="form-label">Trimestres</label>
                    <input type="hidden" id="numTrimestre" name="numTrimestre" value="1">
                </div>
                <div class="col-md-4">
                    <label for="fechaInicioTrimestre" class="form-label">Fecha de inicio Trimestre</label>
                    <input type="date" class="form-control" id="fechaInicioTrimestre" name="fechaInicioTrimestre" required>
                </div>
                <div class="col-md-4">
                    <label for="fechaFinalTrimestre" class="form-label">Fecha final Trimestre</label>
                    <input type="date" class="form-control" id="fechaFinalTrimestre" name="fechaFinalTrimestre" required>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" id="addTrimestre" class="btn btn-secondary">Agregar Trimestre</button>
                <button type="button" id="toggleAllTrimestresBtn" class="btn btn-secondary"></button>
            </div>
            <div id="trimestresContainer"></div>

            <!-- Festivos -->
            <div class="row mb-3" style="background-color: #eaeaea; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreFestivo" class="form-label">Nombre del Festivo</label>
                    <input type="text" class="form-control" id="nombreFestivo" name="nombreFestivo" required>
                </div>
                <div class="col-md-4">
                    <label for="tipoFestivo" class="form-label">Tipo de Festivo</label>
                    <select class="form-control" id="tipoFestivo">
                        <option value="Festius Locals">Dates de festius Locals</option>
                        <option value="Festius Estatals">Dates de festius Estatals</option>
                        <option value="Lliure disposició">Lliure disposició</option>
                        <option value="Períodes de vacances">Períodes de vacances</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="fechaInicioFestivo" class="form-label">Fecha de inicio Festivo</label>
                    <input type="date" class="form-control" id="fechaInicioFestivo" name="fechaInicioFestivo" required>
                </div>
                <div class="col-md-4">
                    <label for="fechaFinalFestivo" class="form-label">Fecha final Festivo</label>
                    <input type="date" class="form-control" id="fechaFinalFestivo" name="fechaFinalFestivo" required>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" id="addFestivo" class="btn btn-secondary">Agregar Festivo</button>
                <button type="button" id="deleteFestivo" class="btn btn-danger" style="display: none;">Eliminar Festivo</button>
                <button type="button" id="toggleAllBtn" class="btn btn-secondary"></button>
            </div>
            <div id="festivosContainer"></div>

            <!--hidden trimestresData-->
            <input type="hidden" id="trimestresData" name="trimestresData">
            <input type="hidden" id="festiusData" name="festiusData">

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        //festius
        var festius = [];

        $("#addFestivo").click(function () {
            var nombreFestivo = $("#nombreFestivo").val().trim();
            if(nombreFestivo === "") { // Verificar si el nombre del festivo está vacío
                alert("Debes ingresar un nombre para el festivo.");
                return;
            }
            // Verificar si el nombre del festivo ya existe en el array festius
            if(festius.some(function(festivo) { return festivo.nom === nombreFestivo; })) {
                alert("Ya existe un festivo con el mismo nombre.");
                return;
            }
            var tipoFestivo = $("#tipoFestivo").val();
            var fechaInicioFestivo = $("#fechaInicioFestivo").val();
            var fechaFinalFestivo = $("#fechaFinalFestivo").val();
            var dataIniciCurs = $("#data_inici").val();
            var dataFinalCurs = $("#data_final").val();
            if (fechaInicioFestivo < dataIniciCurs || fechaFinalFestivo > dataFinalCurs) {
                alert("Las fechas del festivo deben estar dentro de las fechas del curso.");
                return;
            }


            var festiuData = {
                nom: nombreFestivo,
                tipus: tipoFestivo,
                inicio: fechaInicioFestivo, // Quitamos la conversión a ISO
                fin: fechaFinalFestivo // Quitamos la conversión a ISO
            };

            festius.push(festiuData);

            var newFestivo = $('<div>', {class: 'festivo'});
            newFestivo.append('<h3>' + nombreFestivo + '</h3>');
            newFestivo.append('<p><strong>Tipo de festiu:</strong> ' + tipoFestivo + '</p>');
            newFestivo.append('<p><strong>Data inici:</strong> ' + fechaInicioFestivo + '</p>');
            newFestivo.append('<p><strong>Data final:</strong> ' + fechaFinalFestivo + '</p>');

            $("#festiusData").val(JSON.stringify(festius));
            $("#festivosContainer").append(newFestivo);
            $("#deleteFestivo").show();
        });
        $("#deleteFestivo").click(function () {
            festius.pop();
            $("#festivosContainer").children().last().remove();
            if (festius.length === 0) {
                $("#deleteFestivo").hide();
            }
        });

        //trimestres
        var numTrimestre = 1;
        var trimestres = [];

        $("#addTrimestre").click(function () {
            if (numTrimestre > 3) { // Limitar a solo 3 trimestres
                alert("Solo se pueden agregar hasta 3 trimestres.");
                return;
            }

            var trimestreName = "Trimestre " + numTrimestre;
            var fechaInicioTrimestre = $("#fechaInicioTrimestre").val();
            var fechaFinalTrimestre = $("#fechaFinalTrimestre").val();
            var dataIniciCurs = $("#data_inici").val();
            var dataFinalCurs = $("#data_final").val();

            if (fechaInicioTrimestre < dataIniciCurs || fechaFinalTrimestre > dataFinalCurs) {
                alert("Las fechas del trimestre deben estar dentro de las fechas del curso.");
                return;
            }
            if (fechaInicioTrimestre === fechaFinalTrimestre) {
                alert("La fecha de inicio y final del trimestre no pueden ser iguales.");
                return;
            }
            // Validar si las fechas de inicio y final son las mismas que las de otros trimestres
            for (var i = 0; i < trimestres.length; i++) {
                if (trimestres[i].inicio === fechaInicioTrimestre) {
                    alert("La fecha de inicio del trimestre coincide con la de otro trimestre.");
                    return;
                }
                if (trimestres[i].fin === fechaFinalTrimestre) {
                    alert("La fecha final del trimestre coincide con la de otro trimestre.");
                    return;
                }
            }

            var trimestreData = {
                nom: trimestreName,
                inicio: fechaInicioTrimestre,
                fin: fechaFinalTrimestre
            };

            trimestres.push(trimestreData);

            var newTrimestre = $('<div>', {class: 'trimestre'});
            newTrimestre.append('<h3>Trimestre ' + numTrimestre + '</h3>');
            newTrimestre.append('<p><strong>Fecha de inicio:</strong> ' + fechaInicioTrimestre + '</p>');
            newTrimestre.append('<p><strong>Fecha final:</strong> ' + fechaFinalTrimestre + '</p>');
            newTrimestre.append('<div class="col-md-2"><button type="button" class="btn btn-danger deleteTrimestre">Eliminar Trimestre</button></div>');

            $("#trimestresData").val(JSON.stringify(trimestres));
            $("#trimestresContainer").append(newTrimestre);
            numTrimestre++;
        });

        $(document).on("click", ".deleteTrimestre", function(){
            $(this).closest('.trimestre').remove();
            updateTrimestreNumbers();

            var index = $(this).closest('.trimestre').index(); // Obtener el índice del trimestre eliminado
            trimestres.splice(index, 1); // Eliminar el trimestre del array trimestres
            $("#trimestresData").val(JSON.stringify(trimestres)); // Actualizar el valor del campo oculto con los trimestres actualizados
        });

        function updateTrimestreNumbers() {
            var trimestres = $(".trimestre");
            trimestres.each(function(index) {
                $(this).find("h3").text("Trimestre " + (index + 1));
            });
            numTrimestre = trimestres.length + 1;
        }
    });
    </script>
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
