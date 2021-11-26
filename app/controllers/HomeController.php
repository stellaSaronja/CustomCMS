<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use Core\View;

class HomeController {
    
    // public function index() {
    //     View::render('index', ['foo' => 'bar']);
    // }
    public function index() {
        $prods = Product::all();

        View::render('products/index', ['products' => $products]);
    }

    public function home() {
        $users = User::all('username', 'ASC');
        View::render('home', ['users' => $users]);
    }
}