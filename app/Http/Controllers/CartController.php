<?php

namespace App\Http\Controllers;

use App\Actions\AddProductToCart;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CartController extends Controller {
    public function add( Request $request ) {
        $validated = $request->validate( [
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ] );

        try {
            ( new AddProductToCart() )->execute( $validated['product_id'], $validated['quantity'] );
        } catch ( ValidationException $e ) {
            return redirect()->back()->with( 'error', collect($e->errors())->flatten()->first() );
        }

        return back()->with( 'success', 'Product added to cart successfully' );
    }

    public function remove( Request $request ) {
        $validated = $request->validate( [
            'product_id' => 'required|integer|exists:products,id',
        ] );

        try {
            ( new \App\Actions\RemoveProductFromCart() )->execute( $validated['product_id'] );
        } catch ( ValidationException $e ) {
            return redirect()->back()->with( 'error', collect($e->errors())->flatten()->first() );
        }

        return back()->with( 'success', 'Product removed from cart successfully' );
    }

    public function update( Request $request ) {
        $validated = $request->validate( [
            'product_id' => 'required|integer|exists:products,id',
        ] );

        try {
            ( new \App\Actions\UpdateProductInCart() )->execute( $validated['product_id'], $request['type'] );
        } catch ( ValidationException $e ) {
            return redirect()->back()->with( 'error', collect($e->errors())->flatten()->first() );
        }

        return back()->with( 'success', 'Cart updated successfully' );
    }
}
