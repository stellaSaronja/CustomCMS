<?php

namespace Core\Middlewares;

use App\Models\User;

class AuthMiddleware {

    /**
     * Prüfen, ob der/die eingeloggte User*in ein Admin ist.
     */
    public static function isAdmin(): ?bool
    {
        return User::getLoggedIn()?->is_admin;
    }

    /**
     * Prüfen, ob der/die eingeloggte User*in ein Admin ist und andernfalls Fehler 403 Forbidden zurückgeben.
     */
    public static function isAdminOrFail()
    {
        /**
         * Prüfen, ob der/die aktuell eingeloggt User*in Admin ist.
         */
        $isAdmin = self::isAdmin();

        /**
         * Wenn nein, zeigen wir den Fehler 403 Forbidden und erlauben die Ausführung nicht. Der ExceptionHandler
         * kümmert sich um die Anzeige des Fehlers.
         */
        if ($isAdmin !== true) {
            throw new \Exception('Forbidden', 403);
        }
    }

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