<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    // Relación con roles
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'UserRoles',
            'UserId',
            'RoleId'
        );
    }

    // Devuelve el primer rol
    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }

    // ✅ Relación con Customer
    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'id');
    }
}
