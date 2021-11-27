<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use Core\View;

class HomeController {
    
    public function index() {
        $products = Product::all();

        View::render('products/index', ['products' => $products]);
    }

    public function home() {
        $users = User::all();
        View::render('home', ['users' => $users]);
    }
}