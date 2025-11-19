<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    public function __construct()
    {
        // Middleware solo para roles administrativos
        $this->middleware(['auth', 'role:Cajero,Almacenista,Administrador'])->only(['index','store','show']);
        // El cliente puede ver sus facturas con showCliente
        $this->middleware(['auth', 'role:Cliente'])->only(['showCliente']);
    }

    // Listar todas las facturas y mostrar formulario (administradores/cajeros/almacenistas)
    public function index()
    {
        $facturas = Factura::with('cliente', 'creador')->get();
        $clientes = Customer::all();

        return view('facturas', compact('facturas', 'clientes'));
    }

    // Guardar nueva factura desde formulario administrativo
    public function store(Request $request)
    {
        $request->validate([
            'id_cliente'    => 'required|exists:Customers,Id',
            'total'         => 'required|numeric',
            'productos'     => 'required|array'
        ]);

        $factura = Factura::crearFacturaConLineas($request->all(), $request->productos);

        return redirect()->route('facturas.index')->with('success', 'Factura creada correctamente.');
    }

    // Mostrar factura al cliente autenticado
    public function showCliente($id)
    {
        $user = Auth::user();
        $factura = Factura::with(['lineas.product', 'cliente'])->findOrFail($id);

        if ($factura->cliente->Email !== $user->Email) {
            abort(403, 'No tienes permiso para ver esta factura.');
        }

        return view('facturas', compact('factura'));
    }
}
