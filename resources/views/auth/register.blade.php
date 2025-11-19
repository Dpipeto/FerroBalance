@extends('layout.app')

@section('title', 'Registro')

@section('content')
@php
    $fondo = asset('images/ferreteria.png');
@endphp

<div class="w-full min-h-screen flex justify-center items-center text-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">
    <div class="bg-white/90 p-10 rounded-2xl shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Registro de Usuario</h1>

        <form method="POST" action="{{ route('registro') }}" onsubmit="return validarFormulario();">
            @csrf

            <div class="mb-4 text-left">
                <label for="name" class="block mb-1 font-semibold">Nombre completo:</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-left">
                <label for="email" class="block mb-1 font-semibold">Correo electrónico:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 text-left">
                <label for="password" class="block mb-1 font-semibold">Contraseña:</label>
                <input id="password" type="password" name="password" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 text-left">
                <label for="password_confirmation" class="block mb-1 font-semibold">Confirmar contraseña:</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit"
                    class="w-full bg-blue-700 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition">
                Registrarse
            </button>

            <p class="mt-4 text-gray-700 text-sm">
                ¿Ya tienes cuenta? 
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline">Inicia sesión aquí</a>
            </p>
        </form>
    </div>
</div>

<script>
function validarFormulario() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("password_confirmation").value;

    if (password !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        return false;
    }

    return true;
}
</script>
@endsection
