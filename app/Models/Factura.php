<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Factura extends Model
{
    protected $table = 'Invoices';
    protected $primaryKey = 'Id';

    // Campos de timestamps personalizados
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';

    protected $fillable = [
        'InvoiceNumber',
        'CustomerId',
        'Date',
        'DueDate',
        'Subtotal',
        'Tax',
        'Total',
        'Status',
        'CreatedBy',
        'CreatedAt',
        'UpdatedAt'
    ];

    /**
     * Relación con cliente (Customers)
     */
    public function cliente()
    {
        return $this->belongsTo(Customer::class, 'CustomerId', 'Id');
    }

    /**
     * Relación con usuario que crea la factura (Users)
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'id');
    }

    /**
     * Relación con líneas de factura (InvoiceLines)
     */
    public function lineas()
    {
        return $this->hasMany(FacturaLinea::class, 'InvoiceId', 'Id');
    }

    /**
     * Crear factura con líneas asociadas
     */
    public static function crearFacturaConLineas($data, $productos)
    {
        // Crear la factura
        $factura = self::create([
            'InvoiceNumber' => $data['InvoiceNumber'],
            'CustomerId'    => $data['CustomerId'],
            'Date'          => $data['Date'],
            'DueDate'       => $data['DueDate'],
            'Subtotal'      => $data['Subtotal'],
            'Tax'           => $data['Tax'],
            'Total'         => $data['Total'],
            'Status'        => $data['Status'],
            'CreatedBy'     => Auth::id(), // Usuario autenticado
        ]);

        // Crear las líneas de factura
        if (!empty($productos)) {
            foreach ($productos as $p) {
                FacturaLinea::create([
                    'InvoiceId' => $factura->Id,
                    'ProductId' => $p['id_producto'],
                    'Cantidad'  => $p['cantidad'],
                    'Precio'    => $p['precio'],
                    'Descuento' => $p['descuento'] ?? 0
                ]);
            }
        }

        return $factura;
    }
}
