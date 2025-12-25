<?php

namespace App\Models;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'user_id',
        'cart_id',
        'total',
        'status',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected function total(): \Illuminate\Database\Eloquent\Casts\Attribute {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn( $value ) => $value / 100,
            set: fn( $value ) => $value * 100,
        );
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo( User::class );
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo( Cart::class );
    }
}
