<?php

namespace Core;

class Session {

    /**
     * Session starten
     */
    public static function init() {
        /**
         * Den Namen des Session Cookie aus dem app-slug Value setzen.
         */
        session_name(Config::get('app.app-slug', 'cms-session-cookie'));

        /**
         * Cookie lifetime wird beispielsweise für Remember Me Checkboxen verwendet.
         */
        session_start([
            'cookie_lifetime' => 60 * 60 * 24 * 30 // 30 Tage Cookie Lifetime
        ]);
    }

    /**
     * Wert in Session schreiben
     */
    public static function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Wert aus Session auslesen
     */
    public static function get(string $key, mixed $default = null): mixed {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Wert aus Session löschen
     */
    public static function forget(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Wert aus der Session auslesen und danach löschen
     */
    public static function getAndForget(string $key, mixed $default = null): mixed {
        $_value = self::get($key, $default);
        self::forget($key);
        return $_value;
    }

    /**
     * Formular mit alten Werten befüllen, damit der/die User*in die Werte nicht nochmal eingeben muss.
     */
    public static function old(string $key, mixed $default = null): mixed {
        /**
         * $_REQUEST = $_POST & $_GET
         */
        if (isset($_SESSION['$_request'][$key])) {
            $_value = $_SESSION['$_request'][$key];
            unset($_SESSION['$_request'][$key]);
            return $_value;
        }

        /**
         * Andernfalls $default zurückgeben.
         */
        return $default;
    }

    /**
     * Hier setzen wir die Werte aus der $_REQUEST Superglobals in die Session, damit wir sie in der
     * old()-Methode wieder abrufen können.
     */
    public static function initSuperglobals() {
        /**
         * Wurden POST oder GET Daten übergeben, speichern wir sie in die Session.
         */
        if (!empty($_REQUEST)) {
            self::set('$_request', $_REQUEST);
        }
    }
}