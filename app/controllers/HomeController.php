<?php

namespace App\Controllers;

use Core\View;

class HomeController {
    public function index() {
        View::render('index', ['foo' => 'bar']);
        /**
         * @todo: objasniti zasto array
         */
    }
}