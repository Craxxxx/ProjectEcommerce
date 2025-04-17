<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\Carts_items;

class Carts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // 🔁 Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Carts_items::class);
    }

}
