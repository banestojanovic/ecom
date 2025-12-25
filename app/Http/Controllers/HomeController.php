<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Fortify\Features;

class HomeController extends Controller {
    public function __invoke( Request $request ) {
        $page = $request->input( 'page', 1 );

        return Inertia::render( 'home', [
            'products' => Product::paginate( 10, [ '*' ], 'page', $page ),
        ] );
    }
}
