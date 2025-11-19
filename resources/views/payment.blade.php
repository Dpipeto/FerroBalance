@extends('layout.app')

@section('title', 'Detalle de Pago y Factura')

@section('content')
@php
    $fondo = asset('images/ferreteria.png');
@endphp

<div class="w-full min-h-screen flex flex-col items-center justify-center"
     style="background-image: url('{{ $fondo }}'); background-size: cover; background-position: center;">

    <div class="bg-white/90 p-8 rounded-2xl shadow-lg max-w-3xl w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            💳 Pago realizado
        </h2>

        {{-- Datos del pago --}}
        <p><strong>Fecha de Pago:</strong> {{ $payment->PaymentDate }}</p>
        <p><strong>Monto:</strong> ${{ $payment->Amount }}</p>
        <p><strong>Método:</strong> {{ $payment->Method }}</p>

        <hr class="my-6">

        {{-- Datos de la factura asociada al usuario --}}
        @if($factura)
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                🧾 Factura #{{ $factura->InvoiceNumber }}
            </h2>

            <p><strong>Cliente:</strong> {{ $factura->customer->Name }}</p>
            <p><strong>Fecha:</strong> {{ $factura->Date }}</p>
            <p><strong>Total Factura:</strong> ${{ $factura->Total }}</p>

            <h3 class="text-lg font-semibold mt-4">Productos Comprados</h3>
            <table class="w-full border-collapse border border-gray-300 mb-6">
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
                            <td class="border px-4 py-2">{{ $linea->product->Name }}</td>
                            <td class="border px-4 py-2">{{ $linea->Cantidad }}</td>
                            <td class="border px-4 py-2">${{ $linea->Precio }}</td>
                            <td class="border px-4 py-2">${{ $linea->Cantidad * $linea->Precio }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-red-600">No se encontró una factura asociada.</p>
        @endif
    </div>
</div>
@endsection
