@extends('master')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendario Anual</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-bordered">
                <thead class="bg-primary text-white"> <!-- Cambiamos bg-info a bg-primary para un color de fondo azul más vibrante -->
                    <tr>
                        <th>Semana</th>
                        <th>Data</th>
                        <th>Dia</th>
                        <th>Tasca</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Aquí se generará el calendario dinámicamente -->
                    @for ($i = 1; $i <= 4; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>
                            @for ($j = 1; $j <= 7; $j++)
                            <div> Día {{ $j }}</div>
                            @endfor
                        </td>
                        <td>
                            <div>Lunes</div>
                            <div>Martes</div>
                            <div>Miércoles</div>
                            <div>Jueves</div>
                            <div>Viernes</div>
                            <div>Sábado</div>
                            <div>Domingo</div>
                        </td>
                        <td>Tasca</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>

@endsection
