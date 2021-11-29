<?php

namespace App\Controllers;

use App\Models\Product;
use Core\View;

class ProductController {

    public function index() {
        $products = Product::all();

        View::render('products/index', ['products' => $products]);

    }

    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        View::render('products/details', [
            'product' => $product
        ]);
    }
}