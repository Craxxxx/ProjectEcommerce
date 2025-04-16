<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_line1',
        'city',
        'postal_code',
        'country',
        'is_default_shipping',
        'is_default_billing',
    ];

    protected $casts = [
        'is_default_shipping' => 'boolean',
        'is_default_billing'  => 'boolean',
    ];

    // 🔁 Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🛠️ Utility Methods (Optional)

    public function setAsDefaultShipping()
    {
        // Reset others
        static::where('user_id', $this->user_id)->update(['is_default_shipping' => false]);
        $this->update(['is_default_shipping' => true]);
    }

    public function setAsDefaultBilling()
    {
        // Reset others
        static::where('user_id', $this->user_id)->update(['is_default_billing' => false]);
        $this->update(['is_default_billing' => true]);
    }

    public function fullAddress()
    {
        return "{$this->address_line1}, {$this->city}, {$this->postal_code}, {$this->country}";
    }
}
