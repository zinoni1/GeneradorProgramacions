@extends('master')

@section('content')
<div class="container mt-4">
    <div class="alert alert-danger" role="alert">
        Tu usuario no tiene los permisos suficientes para acceder aquí. Solo puedes entrar mediante el usuario admin.
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Ir al Dashboard</a>
</div>
@endsection
