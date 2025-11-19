<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaLinea extends Model
{
    protected $table = 'InvoiceLines';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'InvoiceId',
        'ProductId',
        'Cantidad',
        'Precio',
        'Descuento'
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'InvoiceId', 'Id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'Id');
    }

}
