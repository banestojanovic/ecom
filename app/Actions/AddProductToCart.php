<?php

namespace App\Actions;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class AddProductToCart {

    public \App\Models\Cart $cart;

    /**
     * @throws \Throwable
     */
    public function execute( int $productId, int $quantity ): void {
        $product = rescue(
            fn() => \App\Models\Product::findOrFail( $productId ),
            fn() => throw ValidationException::withMessages( [
                'product_id' => 'The selected product does not exist.',
            ] )
        );

        if ( $product->stock < $quantity ) {
            throw ValidationException::withMessages( [
                'quantity' => 'The requested quantity exceeds available stock.',
            ] );
        }

        $this->cart = ( new Cart() )->get();

        $cartItem = $this->cart->items()->where( 'product_id', $productId )->first();

        $product->stock -= $quantity;
        $product->save();

        if ( $cartItem ) {
            $cartItem->quantity += $quantity;
            $cartItem->save();

            return;
        }

        DB::transaction( function () use ( $product, $quantity ) {
            $this->createCartItem( $product, $quantity );
        } );
    }

    private function createCartItem( Product $product, int $quantity ): void {
        $this->cart->items()->create( [
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'price'      => $product->price,
        ] );
    }

}
