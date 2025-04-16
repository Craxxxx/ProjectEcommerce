<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin'; // important if using custom auth guard

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 🔐 Optional: Access Control Helpers

    public function canManageUsers()
    {
        return true; // Add logic if you have roles within admins
    }

    public function canManageProducts()
    {
        return true;
    }

    public function canManageOrders()
    {
        return true;
    }

    // 📁 Optional: Activity logs, audit, or dashboard-specific relations can go here
}