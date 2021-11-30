<?php

namespace App\Controllers;

use App\Models\Equipment;
use App\Services\CartService;
use Core\Helpers\Redirector;
use Core\View;

class CartController {
    
    /**
     * Cart Übersicht anzeigen
     */
    public function index() {
        /**
         * Inhalt des Cart laden.
         */
        $productsInCart = CartService::get();

        /**
         * View laden und Daten übergeben.
         */
        View::render('cart/index', [
            'products' => $productsInCart
        ]);
    }

    /**
     * Equipment in Cart hinzufügen (+1)
     */
    public function add(int $id) {
        /**
         * Equipment, das hinzugefügt werden soll, laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Equipment in Cart hinzufügen.
         */
        CartService::add($product);

        /**
         * Redirect.
         */
        Redirector::redirect('/cart');
    }

    /**
     * Equipment in Cart entfernen (-1)
     */
    public function remove(int $id) {
        /**
         * Equipment, von dem ein Element entfernt werden soll, laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Ein Element des Equipments entfernen.
         */
        CartService::remove($product);

        /**
         * Redirect.
         */
        Redirector::redirect('/cart');
    }

    /**
     * Equipment komplett aus Cart entfernen (-all)
     */
    public function removeAll(int $id) {
        /**
         * Equipment, das komplett aus dem Cart entfernt werden soll, laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Aus dem Cart entfernen.
         */
        CartService::removeAll($product);

        /**
         * Redirect.
         */
        Redirector::redirect('/cart');
    }
}