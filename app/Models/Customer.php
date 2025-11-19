<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'Customers';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Name',
        'Email',
        'Phone',
        'UserId',
    ];

    // Relación inversa con User
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'IdUsers');
    }
}
