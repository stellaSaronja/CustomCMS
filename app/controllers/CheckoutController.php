<?php

namespace App\Controllers;

use App\Services\CartService;
use App\Models\User;
use App\Models\Orders;
use Core\Middlewares\AuthMiddleware;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class CheckoutController {

    public function __construct()
    {
        AuthMiddleware::isLoggedInOrFail();
    }

    public function summary()
    {
        /**
         * Einträge aus dem Cart und eingeloggte*n User*in holen.
         */
        $cartContent = CartService::get();
        $user = User::getLoggedIn();

        /**
         * View laden und Daten übergeben.
         */
        View::render('checkout/summary', [
            'cartContent' => $cartContent,
            'user' => $user
        ]);
    }

    public function saveOrder()
    {
        /**
         * + Booking Einträge anlegen
         * + Units reduzieren
         */

        /**
         * Einträge aus dem Cart und eingeloggte*n User*in holen.
         */
        $cartContent = CartService::get();
        $user = User::getLoggedIn();

        /**
         * Alle Einträge aus dem Cart durchgehen.
         */
        foreach ($cartContent as $itemFromCart) {
            /**
             * Nachdem ein Equipment mehrmals im Cart sein kann, legen wir hier für jedes einzelne Equipment einen
             * Booking-Eintrag an. Eleganter wäre es, in der bookings Tabelle eine quantity Spalte hinzuzufügen und
             * nicht für dasselbe Equipment mehrere Einträge anzulegen, aber der Einfachheit halber machen wir es
             * jetzt mal so.
             */
            for ($i = 1; $i <= $itemFromCart->count; $i++) {
                /**
                 * Booking Objekt erstellen und befüllen.
                 */
                $cartItem = new Orders();
                $cartItem->fill([
                    'user_id' => $user->id,
                    'foreign_table' => $itemFromCart::class,
                    'foreign_id' => $itemFromCart->id
                ]);
                /**
                 * Booking Objekt in die Datenbank speichern.
                 */
                if (!$cartItem->save()) {
                    /**
                     * Konnte nicht gespeichert werden, schreiben wir einen Fehler und leiten zurück zur Zusammenfassung.
                     */
                    Session::set('errors', ['Cart items could not be saved.']);
                    Redirector::redirect('/checkout');
                }
            }

            /**
             * Hat das Objekt aus dem Cart, das wir grade bearbeiten, eine units-Property, dann entfernen wir die
             * Anzahl der gerade gebuchten Elemente und reduzieren somit den "Lagerbestand."
             */
            if (property_exists($itemFromCart, 'units')) {
                $itemFromCart->units = $itemFromCart->units - $itemFromCart->count;
                $itemFromCart->save();
            }
        }

        /**
         * Nun löschen wir den Inhalt des Carts, der soeben erfolgreich gebucht wurde ...
         */
        CartService::destroy();
        /**
         * ... schreiben eine Erfolgsmeldung und leiten weiter.
         */
        Session::set('success', ['Checkout successfully completed!']);
        Redirector::redirect('/home');
    }
}