<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class ProductController {

    public function index() {
        $prods = Products::all();

        View::render('products/index', ['products' => $products]);
    }

    public function show(int $id)
    {
        /**
         * Gewünschtes Equipment aus der DB laden.
         */
        $equipment = Equipment::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('equipments/show', [
            'equipment' => $equipment
        ]);
    }
}