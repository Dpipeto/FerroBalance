@extends('layout.app')

@section('title', 'Dashboard Administrador')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    {{-- Sidebar lateral --}}
    <div class="w-64 bg-blue-800 text-white flex flex-col">
        <h2 class="text-2xl font-bold p-4 border-b border-blue-700">Admin Panel</h2>
        <nav class="flex-1 p-4 space-y-2">
            <button onclick="showSection('usuarios')" class="w-full text-left hover:bg-blue-700 p-2 rounded">👥 Gestión de Usuarios</button>
            <button onclick="showSection('ventas')" class="w-full text-left hover:bg-blue-700 p-2 rounded">💰 Ventas/Compras</button>
            <button onclick="showSection('grafico')" class="w-full text-left hover:bg-blue-700 p-2 rounded">📊 Gráfico de Compras</button>
        </nav>
    </div>

    {{-- Contenido principal --}}
    <div class="flex-1 p-6">
        <h1 class="text-3xl font-bold mb-6">Dashboard Administrador</h1>

        {{-- Sección Usuarios --}}
        <div id="usuarios" class="section">
            <h2 class="text-xl font-bold mb-4">Gestión de Usuarios</h2>

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Rol</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $user->id }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">{{ $user->role->Name ?? 'Sin rol' }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role_id" class="border rounded px-2 py-1">
                                        @foreach(\App\Models\Role::all() as $role)
                                            <option value="{{ $role->Id }}" {{ $user->role?->Id == $role->Id ? 'selected' : '' }}>
                                                {{ $role->Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded">Actualizar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Sección Ventas --}}
        <div id="ventas" class="section hidden">
            <h2 class="text-xl font-bold mb-4">Ventas/Compras realizadas</h2>

            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">Factura</th>
                        <th class="border px-4 py-2">Cliente</th>
                        <th class="border px-4 py-2">Fecha</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Creada por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr>
                            <td class="border px-4 py-2">{{ $venta->InvoiceNumber }}</td>
                            <td class="border px-4 py-2">{{ $venta->cliente->Name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $venta->Date }}</td>
                            <td class="border px-4 py-2">${{ $venta->Total }}</td>
                            <td class="border px-4 py-2">{{ $venta->creador->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Sección Gráfico dinámico --}}
        <div id="grafico" class="section hidden">
            <h2 class="text-xl font-bold mb-4">Gráfico de Compras por Cliente</h2>
            <canvas id="comprasChart" class="w-full h-64"></canvas>
        </div>
    </div>
</div>

{{-- Script para cambiar secciones --}}
<script>
    function showSection(sectionId) {
        document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
        document.getElementById(sectionId).classList.remove('hidden');
    }
</script>

{{-- Importar Chart.js desde CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Script del gráfico dinámico --}}
<script>
    const clientes = {!! json_encode($clientes, JSON_UNESCAPED_UNICODE) !!};
    const totales = {!! json_encode($totales) !!};

    const ctx = document.getElementById('comprasChart').getContext('2d');
    const comprasChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: clientes,
            datasets: [{
                label: 'Total Compras',
                data: totales,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
