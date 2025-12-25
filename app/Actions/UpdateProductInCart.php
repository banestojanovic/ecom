<?php

namespace App\Actions;

use App\Support\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class UpdateProductInCart {

    public \App\Models\Cart $cart;

    /**
     * @throws \Throwable
     */
    public function execute( int $productId, string $type ): void {
        $product = rescue(
            fn() => \App\Models\Product::findOrFail( $productId ),
            fn() => throw ValidationException::withMessages( [
                'product_id' => 'The selected product does not exist.',
            ] )
        );

        $this->cart = ( new Cart() )->get();

        $cartItem = $this->cart->items()->where( 'product_id', $productId )->first();

        if ( $type === 'increment' ) {
            if ( $product->stock < 1 ) {
                throw ValidationException::withMessages( [
                    'quantity' => 'The requested quantity exceeds available stock.',
                ] );
            }
            $cartItem->quantity += 1;
            $product->stock     -= 1;
            $product->save();
            $cartItem->save();

            return;
        }

        if ( $type === 'decrement' ) {
            if ( $cartItem->quantity <= 1 ) {
                throw ValidationException::withMessages( [
                    'quantity' => 'The quantity cannot be less than 1.',
                ] );
            }
            $cartItem->quantity -= 1;
            $product->stock     += 1;
            $product->save();
            $cartItem->save();
        }
    }

}
