<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Factura;

class AdminController extends Controller
{
    /**
     * Mostrar el dashboard del administrador
     */
    public function index()
    {
        // Todos los usuarios
        $users = User::all();

        // Ventas (facturas) ordenadas por fecha
        $ventas = Factura::with('creador', 'cliente')->orderBy('created_at', 'desc')->get();

        // Datos para gráfico: total de compras por cliente
        $graficoData = Factura::selectRaw('"CustomerId", SUM("Total") as totalCompras')
            ->groupBy('CustomerId')
            ->with('cliente')
            ->get();

        // Preparamos arrays planos para el gráfico
        $clientes = $graficoData->map(fn($f) => (string) $f->cliente?->Name)->values()->toArray();
        $totales = $graficoData->pluck('totalCompras')->values()->toArray();

        return view('dashboard', compact('users', 'ventas', 'clientes', 'totales'));
    }

    /**
     * Actualizar el rol de un usuario
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|integer'
        ]);

        $user = User::findOrFail($id);

        // Si usas tabla pivote UserRoles
        $user->roles()->sync([$request->role_id]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }
}
