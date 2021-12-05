<?php

namespace App\Controllers;

use App\Services\CartService;
use App\Models\User;
use App\Models\Orders;
use Core\Middlewares\AuthMiddleware;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class OrderController {

    public function __construct() {
        AuthMiddleware::isLoggedInOrFail();
    }

    public function summary() {
        /**
         * Einträge aus dem Cart und eingeloggte*n User*in holen.
         */
        $cartContent = CartService::get();

        /**
         * View laden und Daten übergeben.
         */
        View::render('checkout/summary', [
            'cartContent' => $cartContent,
        ]);
    }

    public function saveOrder() {
        /**
         * Einträge aus dem Cart und eingeloggte*n User*in holen.
         */
        $cartContent = CartService::get();

        /**
         * Alle Einträge aus dem Cart durchgehen.
         */
        foreach ($cartContent as $itemFromCart) {
            /**
             * Menge an Produkten
             */
            for ($i = 1; $i <= $itemFromCart->count; $i++) {
                /**
                 * CartItem Objekt erstellen und befüllen.
                 */
                $cartItem = new Orders();
                $cartItem->fill([
                    'user_id' => $user->id,
                    'foreign_table' => $itemFromCart::class,
                    'foreign_id' => $itemFromCart->id
                ]);
                /**
                 * CartItem Objekt in die Datenbank speichern.
                 */
                if (!$cartItem->save()) {
                    /**
                     * Konnte nicht gespeichert werden, schreiben wir einen Fehler und leiten zurück zum Checkout.
                     */
                    Session::set('errors', ['Cart items could not be saved.']);
                    Redirector::redirect('/checkout');
                }
            }
        }

        /**
         * Ist alles erfolgreich gelaufen, löschen wir den Inhalt des Carts.
         */
        CartService::destroy();
        /**
         * Wir schreiben eine Erfolgsmeldung und leiten weiter.
         */
        Session::set('success', ['Checkout successfully completed!']);
        Redirector::redirect('/home');
    }
}