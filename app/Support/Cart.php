<?php

namespace App\Support;

final class Cart {
    public function get(): \App\Models\Cart {
        $cart = \App\Models\Cart::where( 'user_id', auth()->id() )->where( 'status', \App\CartStatus::Active )->first();
        if ( ! $cart ) {
            $cart = \App\Models\Cart::create( [
                'user_id' => auth()->id(),
                'status'  => \App\CartStatus::Active,
            ] );
        }

        $cart->load( 'items.product' );

        return $cart;
    }
}
