<?php

namespace App\Controllers;

use App\Models\User;
// use Core\Helpers\Redirector;
// use Core\Session;
use Core\View;

class UserController {

    /**
     * Alle Einträge listen.
     */
    public function index() {
        /**
         * Alle Objekte über das Model aus der Datenbank laden.
         */
        $users = User::all();

        /**
         * View laden und Daten übergeben.
         */
        View::render('users/index', [
            'users' => $users
        ]);
    }

    /**
     * Einzelnes User anzeigen.
     */
    public function show(int $id) {
        /**
         * Gewünschtes User aus der DB laden.
         */
        $user = User::findOrFail($id);

        /**
         * View laden und Daten übergeben.
         */
        View::render('users/show', [
            'user' => $user
        ]);
    }
}