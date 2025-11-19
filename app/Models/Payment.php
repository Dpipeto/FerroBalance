<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'Payments';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = null; // si no tienes UpdatedAt

    protected $fillable = [
        'PaymentDate',
        'Amount',
        'Method',
        'CreatedBy',
        'CreatedAt',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'id');
    }
}
