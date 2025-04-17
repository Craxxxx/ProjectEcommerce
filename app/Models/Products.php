<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Categories;
use App\Models\Review;
use App\Models\OrderItems;
use App\Models\Carts_items;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // 🔁 Relationships

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Carts_items::class);
    }

    
}
