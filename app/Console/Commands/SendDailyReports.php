<?php

namespace App\Console\Commands;

use App\Mail\DailyReport;
use App\Mail\LowStock;
use App\Models\Order;
use App\OrderStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReports extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends reports of all sold products to admin daily';

    /**
     * Execute the console command.
     */
    public function handle() {
        $user = \App\Models\User::find( 1 );
        if ( ! $user ) {
            return;
        }

        $orders = \App\Models\Order::with( 'cart', 'cart.items', 'cart.items.product' )
                                   ->whereIn( 'status', [ OrderStatus::Created, OrderStatus::Completed ] )
                                   ->where( 'created_at', '>=', now()->subDay() )
                                   ->get();
        $soldProducts = [];

        foreach ( $orders as $order ) {
            foreach ( $order->cart->items as $item ) {
                $productId = $item->product->id;
                if ( ! isset( $soldProducts[ $productId ] ) ) {
                    $soldProducts[ $productId ] = [
                        'product'  => $item->product,
                        'quantity' => 0,
                        'total_revenue' => 0,
                    ];
                }
                $soldProducts[ $productId ]['quantity']      += $item->quantity;
                $soldProducts[ $productId ]['total_revenue'] += $item->quantity * $item->price;
            }
        }

        $revenue = $orders->sum( 'total' );

        Mail::to( $user )->send( new DailyReport( products: $soldProducts, revenue: $revenue ) );
    }
}
