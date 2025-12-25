<?php

namespace App\Actions;

use App\CartStatus;
use App\OrderStatus;
use App\Support\Cart;
use Illuminate\Support\Facades\DB;

final class CreateOrder {

    public function execute() {
        $cart = ( new Cart() )->get();

        DB::transaction( function () use ( $cart ) {
            $order = auth()->user()->orders()->create( [
                'cart_id' => $cart->id,
                'total'   => $cart->total(),
                'status'  => OrderStatus::Created,
            ] );

            $cart->status = CartStatus::Completed;
            $cart->save();
        } );
    }

}
