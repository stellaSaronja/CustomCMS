<?php

namespace App\Controllers;

use App\Models\Product;
// use Core\Helpers\Redirector;
// use Core\Session;
use Core\View;

class ProductController {

    public function index() {
        $products = Product::all();

        View::render('products/index', ['products' => $products]);
    }

    public function show(int $id)
    {
        /**
         * Gewünschtes Equipment aus der DB laden.
         */
        $product = Product::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('products/details', [
            'product' => $product
        ]);
    }
}