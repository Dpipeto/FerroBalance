<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Products';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Description',
        'Price',
        'Cost',
        'Stock',
        'CategoryId',
        'created_at',
        'updated_at'
    ];
}
