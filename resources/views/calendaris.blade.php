@extends('master')

@section('content')

<style>
    .bg-gray {
    background-color: #f2f2f2; /* Puedes ajustar el color a tu preferencia */
    border: 2px solid #e0e0e0;
    padding: 10px;
}

    .bg-white {
        background-color: #ffffff; /* Puedes ajustar el color a tu preferencia */
        border: 2px solid #e0e0e0;
        padding: 10px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Calendari de Cursos</h2>
        </div>
        <div class="card-body">
            @foreach($cursos as $index => $curs)
            <div class="mb-4 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray' }}">
                <h3 class="mb-3">{{ $curs->nom }}</h3>
                <form action="{{ route('curs.show', $curs->id) }}"  class="d-inline">
                    <button type="submit" class="btn btn-info">Veure</button>
                </form>

            </div>
            @endforeach
            <div class="card-body mt-2">
        <a href="{{ route('dashboard') }}" class="btn btn-danger">Tornar</a>
    </div>
        </div>
    </div>

</div>
@endsection
