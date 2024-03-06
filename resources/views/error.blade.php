@extends('master')

@section('content')
<div class="container mt-4">
    <div class="alert alert-danger" role="alert">
        El teu usuari no té els permisos suficients per accedir aquí. Només pots entrar amb l'usuari admin.
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Anar al Dashboard</a>
</div>
@endsection
