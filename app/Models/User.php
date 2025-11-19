<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Users';
    protected $primaryKey = 'IdUsers';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'Password',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'Email';
    }

    public function getAuthPassword()
    {
        return $this->Password;
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
        return $this->hasOne(Customer::class, 'UserId', 'IdUsers');
    }
}
