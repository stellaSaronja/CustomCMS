<?php

namespace App\Services;

use App\Models\Product;

/**
 * Cart Service
 *
 * Services sind üblicherweise Klassen, die Funktionalitäten beinhalten, die weder ein Controller noch ein Model sind.
 * Oft werden sie auch verwendet um Logik, die nicht zwangsläufig auf einen Controller beschränkt ist, wiederverwendbar
 * zu machen.
 */
class CartService {
    /**
     * Wir definieren den Namen des Carts innerhalb der Session.
     */
    const SESSION_KEY = 'product-cart';

    /**
     * Product ins Cart hinzufügen.
     */
    public static function add(Product $product): array {
        /**
         * Cart initialisieren.
         */
        self::init();

        /**
         * Gibt es das Equipment bereits im Cart ...
         */
        if (self::has($product)) {
            /**
             * ... so legen wir es ein weiteres Mal hinein, indem wir den aktuellen Counter um 1 erhöhen.
             */
            $_SESSION[self::SESSION_KEY][$product->id]++;
        } else {
            /**
             * Andernfalls legen wir es genau 1-mal hinein.
             */
            $_SESSION[self::SESSION_KEY][$product->id] = 1;
        }

        /**
         * Neuen Inhalt des Carts zurückgeben.
         */
        return self::get();
    }

    /**
     * Eine Einheit eines Equipments aus dem Cart entfernen.
     */
    public static function remove(Product $product): array {
        /**
         * Cart initialisieren.
         */
        self::init();

        /**
         * Gibt es das Equipment im Cart ...
         */
        if (self::has($product)) {
            /**
             * ... so reduzieren wir es um 1.
             */
            $_SESSION[self::SESSION_KEY][$product->id]--;

            /**
             * Ist der Counter für ein Equipment im Cart auf 0 gefallen, so entfernen wir das Equipment aus dem Cart.
             */
            if ($_SESSION[self::SESSION_KEY][$product->id] <= 0) {
                self::removeAll($product);
            }
        }

        /**
         * Neuen Inhalt des Carts zurückgeben.
         */
        return self::get();
    }

    /**
     * Alle Einheiten eines Products aus dem Cart entfernen.
     */
    public static function removeAll(Product $product): array {
        /**
         * Cart initialisieren.
         */
        self::init();

        /**
         * Gibt es das Equipment im Cart ...
         */
        if (self::has($product)) {
            /**
             * So entfernen wir alle Einheiten davon indem wir den entsprechenden Array-Key unsetten.
             */
            unset($_SESSION[self::SESSION_KEY][$product->id]);
        }

        /**
         * Neuen Inhalt des Carts zurückgeben.
         */
        return self::get();
    }

    /**
     * Inhalt des Carts ausgeben.
     */
    public static function get(): array {
        /**
         * Cart initialisieren.
         */
        self::init();

        /**
         * Array vorbereiten.
         */
        $products = [];
        /**
         * Alle Einträge aus dem Cart durchgehen, ...
         */
        foreach ($_SESSION[self::SESSION_KEY] as $productId => $number) {
            /**
             * ... jeweils das zugehörige Equipment aus der Datenbank laden, ...
             */
            $product = Product::findOrFail($productId);
            /**
             * ... eine zusätzliche Property dynamisch hinzufügen, ...
             */
            $product->count = $number;
            /**
             * ... und "fertiges" Equipment Objekt in das vorbereitete Array speichern.
             */
            $products[] = $product;
        }

        /**
         * Liste aller Equipments aus dem Cart zurückgeben.
         */
        return $products;
    }

    /**
     * Anzahl der Elemente im Cart zurückgeben.
     */
    public static function getCount(): int {
        /**
         * Cart initialisieren.
         */
        self::init();

        /**
         * Counter vorbereiten.
         */
        $count = 0;

        /**
         * Alle Einträge aus dem Cart durchgehen ...
         */
        foreach ($_SESSION[self::SESSION_KEY] as $productId => $number) {
            /**
             * ... und die Anzahl pro Eintrag zum Counter hinzufügen.
             */
            $count = $count + $number;
        }

        /**
         * Ergebnis zurückgeben.
         */
        return $count;
    }

    /**
     * Cart vorbereiten.
     */
    private static function init() {
        /**
         * Existiert der als Klassenkonstante definierte Key noch nicht in der Session, erstellen wir ihn als leeres
         * Array.
         */
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
    }

    /**
     * Convenience Function zur Prüfung, ob ein Equipment bereits im Cart liegt oder nicht.
     */
    private static function has(Product $product): bool {
        return isset($_SESSION[self::SESSION_KEY][$product->id]);
    }

    /**
     * Cart komplett aus der Session löschen.
     */
    public static function destroy()
    {
        if (isset($_SESSION[self::SESSION_KEY])) {
            unset($_SESSION[self::SESSION_KEY]);
        }
    }
}