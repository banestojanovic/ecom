<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store( Request $request ) {

        try {
            ( new \App\Actions\CreateOrder() )->execute();
        } catch ( \Illuminate\Validation\ValidationException $e ) {
            return redirect()->back()->with( 'error', collect( $e->errors() )->flatten()->first() );
        }

        return back()->with( 'success', 'Order placed successfully' );
    }
}
