<?php

namespace Core\Models;

use App\Models\User;
use Core\Database;
use Core\Session;
use Core\Helpers\Redirector;
use Exception;

abstract class AbstractUser extends AbstractModel {

    const LOGGED_IN_STATUS = 'is_logged_in';
    const LOGGED_IN_USER_ID = 'logged_in_user_id';

    public static function findByEmailOrUsername(string $emailOrUsername): ?object {
        /**
         * Whitespace entfernen.
         */
        $emailOrUsername = trim($emailOrUsername);

        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::getTablenameFromClassname();

        /**
         * Query ausführen.
         *
         * Wir setzen hier LIMIT 1, weil wir nur eine*n User*in gleichzeitig einloggen können und daher nur eine*n
         * User*in zurückbekommen wollen aus der Datenbank.
         */
        $result = $database->query("SELECT * FROM $tablename WHERE email = ? OR username = ? LIMIT 1", [
            's:email' => $emailOrUsername,
            's:username' => $emailOrUsername
        ]);

        /**
         * Im AbstractModel haben wir diese Funktionalität aus der all()-Methode herausgezogen und in eine eigene
         * Methode verpackt, damit wir in allen anderen Methoden, die zukünftig irgendwelche Daten aus der Datenbank
         * abfragen, denselben Code verwenden können und nicht Code duplizieren müssen.
         */
        $result = self::handleUniqueResult($result);

        /**
         * Ergebnis zurückgeben.
         */
        return $result;
    }

    /**
     * Überprüfen, ob das übergebene $password mit den gespeicherten Hash übereinstimmt.
     */
    public function checkPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    /**
     * Neues Passwort hashen und setzen.
     */
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Login durchführen.
     */
    public function login(?string $redirect): bool {
        /**
         * Login-Status in die Session speichern.
         */
        Session::set(self::LOGGED_IN_STATUS, true);
        Session::set(self::LOGGED_IN_USER_ID, $this->id);

        /**
         * Wurde eine Redirect-URL übergeben, leiten wir hier weiter.
         */
        Redirector::redirect($redirect);

        /**
         * Wurde keine Redirect-URL übergeben, geben wir true zurück.
         */
        return true;
    }

    /**
     * Logout Methode
     */
    public static function logout(?string $redirect): bool {
        /**
         * Login Status in der Session aktualisieren.
         */
        Session::set(self::LOGGED_IN_STATUS, false);
        Session::forget(self::LOGGED_IN_USER_ID);

        /**
         * Wurde eine Redirect-URL übergeben, leiten wir hier weiter.
         */
        Redirector::redirect($redirect);

        /**
         * Wurde keine Redirect-URL übergeben, geben wir true zurück.
         */
        return true;
    }

    /**
     * Prüfen, ob aktuell ein*e User*in eingeloggt ist.
     */
    public static function isLoggedIn(): bool {
        /**
         * Ist ein*e User*in eingeloggt, so geben wir true zurück ...
         */
        if (
            Session::get(self::LOGGED_IN_STATUS, false) === true
            && Session::get(self::LOGGED_IN_USER_ID, null) !== null
        ) {
            return true;
        }

        /**
         * ... andernfalls false.
         */
        return false;
    }

    /**
     * Aktuell eingeloggten User mit Informationen aus der Session aus der Datenbank abfragen.
     */
    public static function getLoggedIn(): ?object {
        /**
         * Ist ein*e User*in eingeloggt, ...
         */
        if (self::isLoggedIn()) {
            /**
             *  ... so holen wir uns hier die zugehörige ID mit dem default null.
             */
            $userId = Session::get(self::LOGGED_IN_USER_ID, null);

            /**
             * Wurde also eine ID ind er Session gefunden, laden wir den/die User*in aus der Datenbank und geben das
             * Ergebnis zurück.
             */
            if ($userId !== null) {
                return User::findOrFail($userId);
            }
        }
        /**
         * Andernfalls geben wir null zurück.
         */
        return null;
    }
}