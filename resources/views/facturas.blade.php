@extends('layout.app')

@section('title', 'Gestión de Facturas')

@section('content')
@php
    $fondo = asset('images/ferreteria.png'); // Imagen de fondo
@endphp

<div class="w-full min-h-screen flex flex-col items-center justify-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">

    {{-- Si viene una sola factura (vista cliente) --}}
    @isset($factura)
        <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-2xl w-full mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Factura #{{ $factura->InvoiceNumber }}</h2>
            <p><strong>Cliente:</strong> {{ $factura->cliente ? $factura->cliente->Name : 'Cliente no encontrado' }}</p>
            <p><strong>Fecha:</strong> {{ $factura->Date }}</p>
            <p><strong>Total:</strong> ${{ $factura->Total }}</p>

            <h3 class="text-lg font-semibold mt-4">Detalle</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Producto</th>
                        <th class="border px-4 py-2">Cantidad</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->lineas as $linea)
                        <tr>
                            <td class="border px-4 py-2">{{ $linea->product->Name ?? 'Producto no encontrado' }}</td>
                            <td class="border px-4 py-2">{{ $linea->Cantidad }}</td>
                            <td class="border px-4 py-2">${{ $linea->Precio }}</td>
                            <td class="border px-4 py-2">${{ $linea->Cantidad * $linea->Precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- Formulario para registrar nueva factura (roles administrativos) --}}
        <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-2xl w-full mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Registrar Nueva Factura</h2>

            <form method="POST" action="{{ route('facturas.store') }}" class="space-y-4">
                @csrf

                {{-- Cliente --}}
                <div>
                    <label class="block mb-1 font-semibold">Cliente:</label>
                    <select name="id_cliente" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione...</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->Id }}">{{ $cliente->Name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Productos --}}
                <div>
                    <h3 class="text-lg font-semibold mb-2">Productos</h3>
                    <div id="productos" class="space-y-2">
                        <div class="flex space-x-2">
                            <input type="number" name="productos[0][id_producto]" placeholder="ID Producto" required
                                   class="w-1/3 px-2 py-1 border rounded">
                            <input type="number" name="productos[0][cantidad]" placeholder="Cantidad" required
                                   class="w-1/3 px-2 py-1 border rounded">
                            <input type="number" name="productos[0][precio]" placeholder="Precio" step="0.01" required
                                   class="w-1/3 px-2 py-1 border rounded">
                        </div>
                    </div>
                    <button type="button" onclick="agregarProducto()"
                            class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 transition">
                        Agregar otro producto
                    </button>
                </div>

                {{-- Total --}}
                <div>
                    <label class="block mb-1 font-semibold">Total:</label>
                    <input type="number" name="total" step="0.01" required
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Botón --}}
                <div class="text-center">
                    <button type="submit"
                            class="bg-blue-700 text-white font-bold py-2 px-6 rounded hover:bg-blue-600 transition">
                        Registrar Factura
                    </button>
                </div>
            </form>
        </div>

        {{-- Listado de facturas --}}
        <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Listado de Facturas</h2>

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Número</th>
                        <th class="border px-4 py-2">Cliente</th>
                        <th class="border px-4 py-2">Fecha</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facturas as $f)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2 font-semibold">{{ $f->InvoiceNumber ?? $f->Id }}</td>
                            <td class="border px-4 py-2">{{ $f->cliente?->Name ?? 'Cliente no encontrado' }}</td>
                            <td class="border px-4 py-2">{{ $f->Date ? $f->Date->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td class="border px-4 py-2 font-semibold">${{ number_format($f->Total, 2) }}</td>
                            <td class="border px-4 py-2">
                                <span class="px-2 py-1 rounded text-sm font-semibold
                                    @if($f->Status === 'Pagado') bg-green-200 text-green-800
                                    @elseif($f->Status === 'Pendiente') bg-yellow-200 text-yellow-800
                                    @else bg-red-200 text-red-800
                                    @endif">
                                    {{ $f->Status ?? 'Pendiente' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No hay facturas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endisset
</div>

<script>
let contador = 1;
function agregarProducto() {
    const div = document.createElement('div');
    div.classList.add('flex', 'space-x-2', 'mt-2');
    div.innerHTML = `
        <input type="number" name="productos[${contador}][id_producto]" placeholder="ID Producto" required
               class="w-1/3 px-2 py-1 border rounded">
        <input type="number" name="productos[${contador}][cantidad]" placeholder="Cantidad" required
               class="w-1/3 px-2 py-1 border rounded">
        <input type="number" name="productos[${contador}][precio]" placeholder="Precio" step="0.01" required
               class="w-1/3 px-2 py-1 border rounded">
    `;
    document.getElementById('productos').appendChild(div);
    contador++;
}
</script>
@endsection
