<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        $payment = Payment::with('user')->findOrFail($id);

        if ($payment->CreatedBy !== $user->id) {
            abort(403, 'No tienes permiso para ver este pago.');
        }

        // Buscar la última factura creada por este usuario
        $factura = \App\Models\Factura::where('CreatedBy', $user->id)
                    ->latest('Date')
                    ->with(['lineas.product', 'customer'])
                    ->first();

        return view('payment', compact('payment', 'factura'));
    }
}
