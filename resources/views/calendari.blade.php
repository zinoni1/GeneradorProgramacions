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
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Semana</th>
                            <th>Data</th>
                            <th>Dia</th>
                            <th>Tasca</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        @foreach($cursos as $curs)
                            <tr>
                                <td>{{ $curs->id }}</td>
                                <td>{{ $curs->nom }}</td>
                                <td>{{ $curs->data_inici }}</td>
                                <td>{{ $curs->data_final }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </body>
    </html>
@endsection
