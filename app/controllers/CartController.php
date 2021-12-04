<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Core\Helpers\Redirector;
use Core\Validator;
use Core\View;
use Core\Session;

class CartController {
    
    /**
     * Cart Übersicht anzeigen
     */
    public function index() {
        /**
         * Inhalt des Carts laden.
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
     * Produkt in Cart hinzufügen (+1)
     */
    public function add(int $id) {
        /**
         * Produkt, das hinzugefügt werden soll, laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Produkte in Cart hinzufügen.
         */
        CartService::add($product);

        /**
         * Redirect
         */
        Redirector::redirect('/cart');
    }

    /**
     * Produkt in Cart entfernen (-1)
     */
    public function remove(int $id) {
        /**
         * Ein Element, das vom Produkt entfernt werden soll, laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Ein Element des Produkts entfernen.
         */
        CartService::remove($product);

        /**
         * Redirect
         */
        Redirector::redirect('/cart');
    }

    /**
     * Produkte komplett aus Cart entfernen (-all)
     */
    public function removeAll(int $id) {
        /**
         * Produkte, die aus dem Cart entfernt werden sollen, finden und laden.
         */
        $product = Product::findOrFail($id);

        /**
         * Aus dem Cart entfernen.
         */
        CartService::removeAll($product);

        /**
         * Redirect zur Cart Seite
         */
        Redirector::redirect('/cart');
    }

    public function validateOrder() {
        $validator = new Validator();
        $validator->letters($_POST['address'], label: 'Address', required: true);
        $validator->numeric($_POST['address-nr'], label: 'Address', required: true);
        $validator->letters($_POST['city'], label: 'City', required: true);
        $validator->numeric($_POST['postal-code'], label: 'Postal code', required: true);
        $validator->letters($_POST['state'], label: 'State', required: true);

        $validator->letters($_POST['card_holder'], label: 'Card name', required: true);
        $validator->numeric($_POST['card_number'], label: 'Card number', required: true);
        $validator->ccexpire($_POST['expiry_date'], label: 'Expiry date', required: true); 
        $validator->numeric($_POST['cvv'], label: 'CVV', min: 100, required: true);

        $errors = $validator->getErrors();
        if (!isset($_POST['card_type'])) {
            $errors[] = 'Card type is not set.';
        }

        if (!empty($errors)) {
            Session::set('errors', $errors);
            $this->index();
        }

        $order = new Order();
        $order->fill($_POST);
        if ($order->save()) {
            /**
             * 1. Alle Produkte aus dem Cart laden
             * 2. Für jedes Produkt aus dem Cart ein "order item" erstellen
             * 3. Order item in DB speichern
             */
            $orderProducts = CartService::get();
            $orderItems = [];
            $saveOrderItemsSuccessful = true;

            foreach ($orderProducts as $orderProduct) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $orderProduct->id;
                $orderItem->quantity = $orderProduct->count;
                $orderItem->price = $orderProduct->price;

                $saveOrder = $orderItem->save();
                $saveOrderItemsSuccessful = $saveOrderItemsSuccessful && $orderItem->save();

                $orderItems[] = $orderItem;
            }

            if ($saveOrderItemsSuccessful) {
                CartService::destroy();
                View::render('checkout/thanks', []);
            } else {
                foreach ($orderItems as $orderItem) {
                    if ($orderItem->id) {
                        $orderItem->delete();
                    }
                }
                $order->delete();
                Session::set('errors', 'An error occured 1. Please try again!');
                Redirector::redirect('/checkout');
            }

        } else {
            $errors[] = 'An error occured 2. Please try again.';
            Session::set('errors', $errors);

            Redirector::redirect('/cart');
        }
    }
}