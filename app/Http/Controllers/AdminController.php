<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

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

        // Datos para gráfico: total de compras por cliente - usando raw query
        $graficoRaw = DB::table('Invoices')
            ->select('CustomerId', DB::raw('SUM("Total")::numeric as totalcompras'))
            ->groupBy('CustomerId')
            ->get();

        // Mapear datos con información de clientes
        $clientesData = [];
        foreach ($graficoRaw as $row) {
            $cliente = \App\Models\Customer::find($row->CustomerId);
            // PostgreSQL devuelve en minúsculas, accedemos así
            $total = (float) ($row->totalcompras ?? $row->totalCompras ?? 0);
            $clientesData[] = [
                'name' => $cliente?->Name ?? 'Sin nombre',
                'total' => $total
            ];
        }

        // Preparamos arrays planos para el gráfico
        $clientes = array_map(fn($c) => $c['name'], $clientesData);
        $totales = array_map(fn($c) => $c['total'], $clientesData);

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
