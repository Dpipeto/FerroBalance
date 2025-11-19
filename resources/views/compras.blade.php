@extends('layout.app')

@section('title', 'Carrito de Compras')

@section('content')
@php
    $fondo = asset('images/ferreteria.png'); // tu imagen de fondo
@endphp

<div class="w-full min-h-screen flex flex-col items-center justify-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">

    {{-- Tarjeta con fondo blanco semitransparente para legibilidad --}}
    <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-3xl w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Carrito de Compras</h1>

        {{-- Mostrar productos en el carrito --}}
        @if(empty($cart))
            <p class="text-gray-600 text-center">Tu carrito está vacío.</p>
        @else
            <table class="w-full border-collapse border border-gray-300 mb-6">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Producto</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">Cantidad</th>
                        <th class="border px-4 py-2">Subtotal</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item['name'] }}</td>
                            <td class="border px-4 py-2">${{ $item['price'] }}</td>
                            <td class="border px-4 py-2">{{ $item['cantidad'] }}</td>
                            <td class="border px-4 py-2">${{ $item['price'] * $item['cantidad'] }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('compras.destroy', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Botón para realizar compra y generar factura --}}
            <form action="{{ route('compras.checkout') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700">
                    🧾 Realizar Compra
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
