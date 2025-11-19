<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Factura;
use App\Models\FacturaLinea;

class CompraController extends Controller
{
    // Mostrar carrito (solo clientes autenticados)
    public function index()
    {
        $user = Auth::user();

        if (!Auth::check() || $user?->role?->Name !== 'Cliente') {
            abort(403, 'Acceso denegado');
        }

        $cart = session()->get('cart', []);
        return view('compras', compact('cart'));
    }

    // Añadir producto al carrito
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!Auth::check() || $user?->role?->Name !== 'Cliente') {
            abort(403, 'Acceso denegado');
        }

        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->Id])) {
            $cart[$product->Id]['cantidad']++;
        } else {
            $cart[$product->Id] = [
                'id' => $product->Id,
                'name' => $product->Name,
                'price' => $product->Price,
                'cantidad' => 1,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Producto añadido al carrito.');
    }

    // Eliminar producto del carrito
    public function destroy($id)
    {
        $user = Auth::user();

        if (!Auth::check() || $user?->role?->Name !== 'Cliente') {
            abort(403, 'Acceso denegado');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('compras.index')->with('success', 'Producto eliminado del carrito.');
    }

    // ✅ Generar factura al comprar
public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'El carrito está vacío.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['cantidad']);
        $tax = $subtotal * 0.19;
        $total = $subtotal + $tax;

        // Buscar el cliente asociado (puede ser por email o IdUsers)
        $customer = \App\Models\Customer::where('Email', $user->Email)->first();

        if (!$customer) {
            return back()->with('error', 'No existe un cliente asociado a este usuario.');
        }

        // Crear factura
        $factura = Factura::create([
            'InvoiceNumber' => uniqid('FAC-'),
            'CustomerId'    => $customer->Id,
            'Date'          => now(),
            'DueDate'       => now()->addDays(7),
            'Subtotal'      => $subtotal,
            'Tax'           => $tax,
            'Total'         => $total,
            'Status'        => 'Pendiente',
            'CreatedBy'     => $user->IdUsers,
        ]);

        foreach ($cart as $item) {
            FacturaLinea::create([
                'InvoiceId' => $factura->Id,
                'ProductId' => $item['id'],
                'Cantidad'  => $item['cantidad'],
                'Precio'    => $item['price'],
                'Descuento' => 0,
            ]);
        }

        // Registrar pago
        $payment = \App\Models\Payment::create([
            'PaymentDate' => now(),
            'Amount'      => $total,
            'Method'      => 'Efectivo',
            'CreatedBy'   => $user->IdUsers,
            'CreatedAt'   => now(),
            'InvoiceId'   => $factura->Id,
        ]);

        session()->forget('cart');

        // ✅ Redirigir al detalle del pago
        return redirect()->route('payments.show', $payment->Id)
            ->with('success', 'Factura y pago registrados correctamente.');
    }

}
