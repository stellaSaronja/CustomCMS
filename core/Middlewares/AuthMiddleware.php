<?php

namespace Core\Middlewares;

use App\Models\User;

class AuthMiddleware {

    /**
     * Prüfen, ob eine Person eingeloggt ist.
     */
    public static function isLoggedInOrFail() {
        /**
         * Prüfen, ob der/die User*in eingeloggt ist.
         */
        $isLoggedIn = User::isLoggedIn();

        /**
         * Wenn nein, werfen wir einen Fehler 401 Unauthorized und brechen damit die Ausführung ab. Der ExceptionHandler
         * kümmert sich um die Anzeige des Fehlers.
         */
        if ($isLoggedIn !== true) {
            throw new \Exception('Unauthorized', 401);
        }
    }

    /**
     * Alias für User::isLoggedIn()
     */
    public static function isLoggedIn () {
        return User::isLoggedIn();
    }
}