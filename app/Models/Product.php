<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Products';   // nombre real de tu tabla
    protected $primaryKey = 'Id';    // clave primaria
    public $timestamps = false;      // si no usas created_at/updated_at automáticos

    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'Cost',
        'Stock',
        'CategoryId',
        'CreatedAt',
        'UpdatedAt'
    ];
}
