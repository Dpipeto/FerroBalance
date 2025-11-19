@extends('layout.app')

@section('title', 'Iniciar Sesión')

@section('content')
@php
    $fondo = asset('images/ferreteria.png');
@endphp

<div class="w-full min-h-screen flex justify-center items-center text-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">
    <div class="bg-white/90 p-10 rounded-2xl shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Iniciar Sesión
        </h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4 text-left">
                <label for="Email" class="block mb-1 font-semibold">Correo electrónico:</label>
                <input id="Email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 text-left">
                <label for="Password" class="block mb-1 font-semibold">Contraseña:</label>
                <input id="Password" type="password" name="password" required
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition">
                Ingresar
            </button>
        </form>
    </div>
</div>
@endsection
