<?php

namespace App\Models;

use App\CartStatus;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'status' => CartStatus::class,
    ];

    public function items() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function total(): float
    {
        return $this->items->sum(function (CartItem $item) {
            return $item->quantity * $item->price;
        });
    }
}
