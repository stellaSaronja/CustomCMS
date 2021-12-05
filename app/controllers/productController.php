<?php

namespace App\Controllers;

use App\Models\Product;
use Core\View;

class ProductController {

    /**
     * Index Seite anzeigen
     */
    public function index() {
        $products = Product::all();

        View::render('products/index', ['products' => $products]);
    }

    /**
     * Produktübersichtsseite anzeigen
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        View::render('products/details', [
            'product' => $product
        ]);
    }
}