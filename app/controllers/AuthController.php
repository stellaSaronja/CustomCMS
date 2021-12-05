<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\Validator;
use Core\View;

class AuthController
{

    /**
     * Login Formular anzeigen
     */
    public function loginForm() {
        /**
         * Wenn ein*e User*in eingeloggt ist, leiten wir auf die Home Seite weiter.
         */
        if (User::isLoggedIn()) {
            Redirector::redirect('/home');
        }

        /**
         * Andernfalls zeigen wir das Login Formular an.
         */
        View::render('auth/login');
    }

    /**
     * Daten aus Login Formular entgegennehmen und verarbeiten.
     */
    public function loginDo() {
        /**
         * 1) Username & Passwort ins Login Formular eingeben
         * 2) Remember Me Checkbox anhakerln (optional)
         * 3) Formular absenden
         * ---
         * 4) Gibts den/die User*in schon? ja: weiter, nein: Fehlermeldung
         * 5) Passwort aus DB abrufen (Salted Hashes)
         * 6) Passwort aus Eingabe und DB ident? ja: weiter, nein: Fehlermeldung
         * 7) "Remember Me" angehakerlt? ja: $exp=7, nein: $exp=0 (für die aktuelle Browser Session, bis der Tab
         * geschlossen wird)
         * 8) Session schreiben: logged_in=>true
         * 9) Redirect zu bspw. Dashboard/Home Seite/whatever
         */

        /**
         * User anhand einer Email-Adresse oder eines Usernames aus der Datenbank laden (s. AbstractUser)
         */
        $user = User::findByEmailOrUsername($_POST['username-or-email']);

        /**
         * Fehler-Array vorbereiten
         */
        $errors = [];

        /**
         * Existiert schon ein*e User*in in der Datenbank und stimmt das Passwort überein?
         */
        if (empty($user) || !$user->checkPassword($_POST['password'])) {
            /**
             * Wenn nein: Fehler!
             */
            $errors[] = 'Username/E-Mail or password are wrong.';
        } else {
            /**
             * Wenn ja: weiter.
             */
            $user->login('/home');
        }

        /**
         * Fehler in die Session schreiben und zum Login zurückleiten
         */
        Session::set('errors', $errors);
        Redirector::redirect('/login');
    }

    /**
     * Logout und Redirect auf die Startseite
     */
    public function logout() {
        User::logout('/');
    }

    /**
     * Registrierungsformular anzeigen
     */
    public function signupForm() {
        /**
         * Wenn ein*e User*in schon eingeloggt ist, leiten wir auf die Startseite weiter.
         */
        if (User::isLoggedIn()) {
            Redirector::redirect('/home');
        }

        /**
         * Andernfalls wird das Signup Formular angezeigt.
         */
        View::render('auth/signup');
    }

    /**
     * Daten aus dem Registrierungsformular entgegennehmen und verarbeiten.
     */
    public function signupDo() {
        /**
         * 1. Daten validieren
         * 2. erfolgreich: weiter, nicht erfolgreich: Fehler
         * 3. Gibts E-Mail oder Username schon in der DB?
         * 4. ja: Fehler, nein: weiter
         * 5. User Object erstellen und in die Datenbank speichern
         * 6. Weiterleiten zum Login
         */

        /**
         * Formulardaten validieren.
         */
        $validator = new Validator();
        $validator->email($_POST['email'], 'E-Mail', required: true);
        $validator->unique($_POST['email'], 'E-Mail', User::TABLENAME, 'email');
        $validator->unique($_POST['username'], 'Username', User::TABLENAME, 'username');
        $validator->password($_POST['password'], 'Passwort', min: 8, required: true);

        /**
         * Password mit password_repeat vergleichen
         */
        $validator->compare([
            $_POST['password'],
            'Password'
        ], [
            $_POST['password_repeat'],
            'Repeat password'
        ]);

        /**
         * Fehler aus dem Validator auslesen. (leer => keine Fehler)
         */
        $errors = $validator->getErrors();

        /**
         * Wenn es Fehler gibt ...
         */
        if (!empty($errors)) {
            /**
             * ... speichern wir sie in die Session und leiten zurück zum Formular.
             */
            Session::set('errors', $errors);
            Redirector::redirect('/signup');
            exit;
        }

        /**
         * Neuen User anlegen, Daten sind korrekt validiert worden
         */
        $user = new User();
        $user->fill($_POST);
        $user->setPassword($_POST['password']);

        /**
         * Neue*n User*in in die Datenbank speichern.
         * Wenn save() = true -> erfolgreich gespeichert
         */
        if ($user->save()) {
            /**
             * Wenn keine Fehler aufgetreten sind, leiten wir weiter zum Login Formular.
             */
            Session::set('success', ['Welcome!']);
            $user->login('/login');
        } else {
            /**
             * Fehlermeldung erstellen und in die Session speichern.
             */
            $errors[] = 'There has been a problem. Please try again! :(';
            Session::set('errors', $errors);

            /**
             * Redirect zurück zum Registrierungsformular.
             */
            Redirector::redirect('/sign-up');
        }
    }

}
