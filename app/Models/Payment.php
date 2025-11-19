<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'Payments';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    protected $fillable = [
        'PaymentDate',
        'Amount',
        'Method',
        'CreatedBy',
        'created_at',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'id');
    }
}
