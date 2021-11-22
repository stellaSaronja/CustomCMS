<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController {

    public function index() {
        $prods = Products::all();

        View::render('products/index', ['products' => $products]);
    }
}