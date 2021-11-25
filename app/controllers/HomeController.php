<?php

namespace App\Controllers;

use App\Models\User;
use Core\View;

/**
 * Beispiel Controller
 */
class HomeController
{

    /**
     * Beispielmethode
     */
    public function index()
    {
        View::render('index', ['foo' => 'bar']);
        /**
         * @todo: objasniti zasto array
         */
    }

    /**
     * Alle users auflisten
     */
    public function home()
    {
        /**
         * Alle users aus der Datenbank laden und von der Datenbank sortieren lassen.
         */
        $users = User::all('username', 'ASC');

        /**
         * View laden und Daten übergeben.
         */
        View::render('home', [
            'users' => $users
        ]);
    }
}