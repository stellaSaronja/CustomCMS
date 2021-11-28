<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\User;
use Core\View;

class HomeController {
    
    public function index() {
        $prods = Product::all();

        View::render('products/index', ['products' => $products]);
    }

    /**
     * Alle users auflisten
     */
    public function home()
    {
        /**
         * Alle users aus der Datenbank laden und von der Datenbank sortieren lassen.
         */
        $users = User::all('username', 'ASC');

        /**
         * View laden und Daten �bergeben.
         */
        View::render('home', [
            'users' => $users
        ]);
    }
}