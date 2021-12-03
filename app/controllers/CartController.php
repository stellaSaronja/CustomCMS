<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Orders;
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

    // public function summary() {
    //     /**
    //      * Produkte aus dem Cart laden.
    //      */
    //     $productsInCart = CartService::get();

    //     /**
    //      * View laden und Daten übergeben.
    //      */
    //     View::render('cart/checkout', [
    //         'products' => $productsInCart
    //     ]);

    //     /**
    //      * unos adrese i nacina placanja
    //      * kontrola da je sve uneseno
    //      */
    // }

    // public function saveOrder() {
    //     /**
    //      * snimiti podatke u bazi
    //      * napraviti model za narudzbu
    //      */
    //     $validator = new Validator();
    //     $validator->text($_POST['address'], label: 'Street name', required: true);
    //     $validator->alphanumeric($_POST['address-nr'], label: 'House number', required: true);
    //     $validator->text($_POST['city'], label: 'City', required: true);
    //     $validator->int($_POST['postal-code'], label: 'Postal code', required: true);
    //     $validator->text($_POST['state'], label: 'State', required: true);

    //     $errors = $validator->getErrors();

    //     if (!empty($errors)) {
    //         /**
    //          * ... dann speichern wir sie in die Session, damit sie im View ausgegeben werden können und leiten dann
    //          * zurück zum Formular.
    //          */
    //         Session::set('errors', $errors);
    //         Redirector::redirect('/cart');
    //         exit;
    //     }

    //     $orders = new Orders();
    //     $orders->fill($_POST);
    //     $orders->setAddress($_POST['address']);
    //     /*
    //      * ok onda treba spremiti i prikazati sljedeći ekran
    //      */

    //     /**
    //      * Neue*n User*in in die Datenbank speichern.
    //      *
    //      * Die User::save() Methode gibt true zurück, wenn die Speicherung in die Datenbank funktioniert hat.
    //      */
    //     if ($orders->save()) {
    //         /**
    //          * Hat alles funktioniert und sind keine Fehler aufgetreten, leiten wir zum Login Formular.
    //          *
    //          * Um eine Erfolgsmeldung ausgeben zu können, verwenden wir dieselbe Mechanik wie für die errors.
    //          */
    //         Session::set('success', ['Successfully saved!']);
    //         $orders->index('/cart/index');
    //     } else {
    //         /**
    //          * Fehlermeldung erstellen und in die Session speichern.
    //          */
    //         $errors[] = 'There has been a problem. Please try again! :(';
    //         Session::set('errors', $errors);

    //         /**
    //          * Redirect zurück zum Registrierungsformular.
    //          */
    //         Redirector::redirect('/checkout');
    //     }
    // }
}