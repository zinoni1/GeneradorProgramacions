@extends('master')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Formulario de creación de programaciones</h1>
        <form action="{{ route('curs.store') }}" method="POST">
            @csrf

            <!-- Información del ciclo y módulos formativos -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="ciclo" class="form-label">Ciclo</label>
                    <input type="text" class="form-control" id="ciclo" name="ciclo" required>
                </div>
            </div>

            <!-- Módulos Formativos (MF) -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="numMf" class="form-label">Módulos Formativos (MF)</label>
                    <input type="hidden" id="numMf" name="numMf" value="1">
                </div>
                <div class="col-md-4">
                    <label for="nombreMf" class="form-label">Nombre del Módulo Formativo</label>
                    <input type="text" class="form-control" id="nombreMf" name="nombreMf" required>
                </div>
                <div class="col-md-4">
                    <label for="ufsMf" class="form-label">Número de UF por Módulo</label>
                    <input type="number" class="form-control" id="ufsMf" name="ufsMf" required>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" id="addMf" class="btn btn-secondary">Agregar Módulo Formativo</button>
                <button type="button" id="toggleAllMfBtn" class="btn btn-secondary"></button>
            </div>
            <div id="mfContainer"></div>

            <!-- UF (Unidades Formativas) -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="numUf" class="form-label">Unidades Formativas (UF)</label>
                    <input type="hidden" id="numUf" name="numUf" value="1">
                </div>
                <div class="col-md-4">
                    <label for="nombreUf" class="form-label">Nombre de la UF</label>
                    <input type="text" class="form-control" id="nombreUf" name="nombreUf" required>
                </div>
                <div class="col-md-4">
                    <label for="semanasUf" class="form-label">Número de Semanas por UF</label>
                    <input type="number" class="form-control" id="semanasUf" name="semanasUf" required>
                </div>
                <div class="col-md-4">
                    <label for="ordenUf" class="form-label">Orden de la UF</label>
                    <input type="text" class="form-control" id="ordenUf" name="ordenUf" readonly>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" id="addUf" class="btn btn-secondary">Agregar UF</button>
            </div>

            <!-- Gestio Semana -->
            <div class="row mb-3" style="background-color: #f2f2f2; padding: 15px;">
                <div class="col-md-4">
                    <label for="nombreUf" class="form-label">Día de la semana</label>
                    <input type="text" class="form-control" id="nombreUf" name="nombreUf" required>
                </div>
                <div class="col-md-4">
                    <label for="horasDia" class="form-label">Horas por día</label>
                    <input type="number" class="form-control" id="horasDia" name="horasDia" required>
                </div>
            </div>
            <div class="mb-3">
                <button type="button" id="addDia" class="btn btn-secondary">Agregar Día</button>
            </div>
            <div id="semanaContainer"></div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Módulos Formativos (MF)
            var numMf = 1;
            var mfs = [];

            $("#addMf").click(function () {
                var nombreMf = $("#nombreMf").val().trim();
                var ufsMf = $("#ufsMf").val();
                var sesionesDia = $("#sesiones_dia").val();
                var horasSesion = $("#horas_sesion").val();

                if(nombreMf === "") {
                    alert("Debes ingresar un nombre para el Módulo Formativo.");
                    return;
                }

                var mfData = {
                    nombre: nombreMf,
                    ufs: ufsMf,
                    sesiones: sesionesDia,
                    horas: horasSesion
                };

                mfs.push(mfData);

                var newMf = $('<div>', {class: 'mf'});
                newMf.append('<h3>' + nombreMf + '</h3>');
                newMf.append('<p><strong>Número de UF:</strong> ' + ufsMf + '</p>');
                newMf.append('<p><strong>Número de Sesiones por semana:</strong> ' + sesionesDia + '</p>');
                newMf.append('<p><strong>Horas por Sesión:</strong> ' + horasSesion + '</p>');
                newMf.append('<div class="col-md-2"><button type="button" class="btn btn-danger deleteMf">Eliminar Módulo Formativo</button></div>');

                $("#mfContainer").append(newMf);
                $("#numMf").val(numMf); // Actualizar el número de MF
                numMf++;
            });

            $(document).on("click", ".deleteMf", function(){
                $(this).closest('.mf').remove();
                numMf--;
                $("#numMf").val(numMf); // Actualizar el número de MF
            });

            // Unidades Formativas (UF)
            var numUf = 1;
            var ufs = [];

            $("#addUf").click(function () {
                var nombreUf = $("#nombreUf").val().trim();
                var semanasUf = $("#semanasUf").val();
                var ordenUf = numUf; // Se asigna automáticamente el orden al agregar la UF

                if(nombreUf === "") {
                    alert("Debes ingresar un nombre para la UF.");
                    return;
                }

                var ufData = {
                    nombre: nombreUf,
                    semanas: semanasUf,
                    orden: ordenUf // Se asigna automáticamente el orden al agregar la UF
                };

                ufs.push(ufData);

                var newUf = $('<div>', {class: 'uf'});
                newUf.append('<h3>' + nombreUf + '</h3>');
                newUf.append('<p><strong>Número de Semanas:</strong> ' + semanasUf + '</p>');
                newUf.append('<p><strong>Orden:</strong> ' + ordenUf + '</p>');
                newUf.append('<div class="col-md-2"><button type="button" class="btn btn-danger deleteUf">Eliminar UF</button></div>');

                $("#ufContainer").append(newUf);
                $("#numUf").val(numUf); // Actualizar el número de UF
                numUf++;
            });

            $(document).on("click", ".deleteUf", function(){
                $(this).closest('.uf').remove();
                numUf--;
                $("#numUf").val(numUf); // Actualizar el número de UF
            });

            // Gestión de la semana
            var numDias = 1;
            var dias = [];

            $("#addDia").click(function () {
                var nombreDia = $("#nombreUf").val().trim();
                var horasDia = $("#horasDia").val();

                if(nombreDia === "") {
                    alert("Debes ingresar un día de la semana.");
                    return;
                }

                var diaData = {
                    nombre: nombreDia,
                    horas: horasDia
                };

                dias.push(diaData);

                var newDia = $('<div>', {class: 'dia'});
                newDia.append('<h3>' + nombreDia + '</h3>');
                newDia.append('<p><strong>Horas por día:</strong> ' + horasDia + '</p>');
                newDia.append('<div class="col-md-2"><button type="button" class="btn btn-danger deleteDia">Eliminar Día</button></div>');

                $("#semanaContainer").append(newDia);
                numDias++;
            });

            $(document).on("click", ".deleteDia", function(){
                $(this).closest('.dia').remove();
                numDias--;
            });
        });
    </script>
@endsection
