<?php

namespace App\Actions;

use App\Support\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class RemoveProductFromCart {

    public \App\Models\Cart $cart;

    /**
     * @throws \Throwable
     */
    public function execute( int $productId ): void {
        $product = rescue(
            fn() => \App\Models\Product::findOrFail( $productId ),
            fn() => throw ValidationException::withMessages( [
                'product_id' => 'The selected product does not exist.',
            ] )
        );

        $this->cart = ( new Cart() )->get();

        $cartItem = $this->cart->items()->where( 'product_id', $productId )->first();

        $product->stock += $cartItem->quantity;
        $product->save();

        $cartItem->delete();
    }

}
