<?php

namespace App\Controllers;

use Core\Helpers\Redirector;
use Core\Session;

class UserController {
    
    public function loginForm() {
        if (User::isLoggedIn()) {
            Redirector::redirect('/home');
        }

        View::render();
        /**
         * @todo: finish
         */
    }
}