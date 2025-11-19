@extends('layout.app')

@section('title', 'Gestión de Productos')

@section('content')
@php
    $fondo = asset('images/ferreteria.png');
@endphp

<div class="w-full min-h-screen flex flex-col items-center justify-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">

    {{-- SOLO roles internos pueden registrar productos --}}
    @auth
        @if(auth()->user()->role->Name === 'Cajero' || auth()->user()->role->Name === 'Administrador')
        <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-2xl w-full mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registrar Nuevo Producto</h2>

            <form method="POST" action="{{ route('productos.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block mb-1 font-semibold">Nombre:</label>
                    <input type="text" name="Name" class="w-full px-3 py-2 border rounded" required>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Descripción:</label>
                    <textarea name="Description" class="w-full px-3 py-2 border rounded" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Precio:</label>
                        <input type="number" name="Price" step="0.01" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Costo:</label>
                        <input type="number" name="Cost" step="0.01" class="w-full px-3 py-2 border rounded" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Stock:</label>
                        <input type="number" name="Stock" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Categoría ID:</label>
                        <input type="number" name="CategoryId" class="w-full px-3 py-2 border rounded" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-700 text-white font-bold py-2 px-6 rounded hover:bg-blue-600 transition">
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
        @endif
    @endauth

    {{-- Listado de productos visible para TODOS --}}
    <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-5xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Listado de Productos</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nombre</th>
                    <th class="border px-4 py-2">Descripción</th>
                    <th class="border px-4 py-2">Precio</th>
                    <th class="border px-4 py-2">Costo</th>
                    <th class="border px-4 py-2">Stock</th>
                    <th class="border px-4 py-2">Categoría</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $p)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $p->Id }}</td>
                        <td class="border px-4 py-2">{{ $p->Name }}</td>
                        <td class="border px-4 py-2">{{ $p->Description }}</td>
                        <td class="border px-4 py-2">{{ $p->Price }}</td>
                        <td class="border px-4 py-2">{{ $p->Cost }}</td>
                        <td class="border px-4 py-2">{{ $p->Stock }}</td>
                        <td class="border px-4 py-2">{{ $p->CategoryId }}</td>
                        <td class="border px-4 py-2">
                            <div class="flex justify-center space-x-3">
                                {{-- SOLO clientes autenticados pueden añadir al carrito --}}
                                @auth
                                    @if(auth()->user()->role->Name === 'Cliente')
                                        <form action="{{ route('compras.store') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $p->Id }}">
                                            <button type="submit" class="flex items-center space-x-1">
                                                <img src="{{ asset('images/carrito.png') }}" class="w-6 h-6 inline-block" alt="Añadir al carrito">
                                                <span class="text-sm">Añadir al carrito</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Botones editar/eliminar solo para roles internos --}}
                                    @if(auth()->user()->role->Name === 'Cajero' || auth()->user()->role->Name === 'Administrador')
                                        <a href="{{ route('productos.edit', $p->Id) }}">
                                            <img src="{{ asset('images/actualizar.png') }}" class="w-6 h-6 inline-block" alt="Actualizar" title="Actualizar">
                                        </a>

                                        <form action="{{ route('productos.destroy', $p->Id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Desea eliminar este producto?')">
                                                <img src="{{ asset('images/trash.png') }}" class="w-6 h-6 inline-block" alt="Eliminar" title="Eliminar">
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Botón continuar con el pago SOLO para clientes --}}
        @auth
            @if(auth()->user()->role->Name === 'Cliente')
                <div class="mt-6 text-center">
                    <a href="{{ route('compras.index') }}"
                       class="bg-green-600 text-white font-bold py-2 px-6 rounded hover:bg-green-500 transition">
                        Continuar con el pago
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
