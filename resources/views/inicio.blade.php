@extends('layout.app')

@section('title', 'Inicio')

@section('content')
@php
    $fondo = asset('images/ferreteria.png');
@endphp

<div class="w-full min-h-screen flex justify-center items-center text-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">
    <div class="bg-white/90 p-10 rounded-2xl shadow-lg max-w-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            Bienvenido a <span class="text-blue-700">FerroBalance</span>
        </h1>
        <p class="text-lg text-gray-600">
            Selecciona una opción del menú superior para comenzar.
        </p>
    </div>
</div>
@endsection
