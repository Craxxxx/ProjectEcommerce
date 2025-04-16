<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Review;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    // 🔁 Relationships

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 📦 Cart Management

    public function addToCart(Product $product, int $quantity = 1)
    {
        $cart = $this->cart()->firstOrCreate([]);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);
        }

        return $item ?? true;
    }

    public function removeFromCart(Product $product)
    {
        $cart = $this->cart;
        if (!$cart) return false;

        return $cart->items()->where('product_id', $product->id)->delete();
    }

    public function clearCart()
    {
        $cart = $this->cart;
        if (!$cart) return false;

        return $cart->items()->delete();
    }

    // 🧾 Order Utilities

    public function placeOrder(Address $shippingAddress, Address $billingAddress = null)
    {
        $cart = $this->cart;
        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception("Cart is empty.");
        }

        return DB::transaction(function () use ($cart) {
            $total = $cart->items->sum(fn ($item) => $item->product->price * $item->quantity);

            $order = $this->orders()->create([
                'total_amount' => $total,
                'status'       => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $this->clearCart();

            return $order;
        });
    }

    // 📬 Default Address Helpers

    public function getDefaultShippingAddress()
    {
        return $this->addresses()->where('is_default_shipping', true)->first();
    }

    public function getDefaultBillingAddress()
    {
        return $this->addresses()->where('is_default_billing', true)->first();
    }
}
