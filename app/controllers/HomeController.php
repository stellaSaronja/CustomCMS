<?php

namespace App\Controllers;

use Core\View;

class HomeController {
    
    public function index() {
        View::render('index', ['foo' => 'bar']);
    }

    public function home() {
        $users = User::all('username', 'ASC');
        View::render('home', ['users' => $users]);
    }
}