<?php

namespace Core;

class Bootloader {

    public function __construct(){
        Session::init();

        Session::initSuperGlobals();

        define('BASE_URL', Config::get('app.baseurl', 'http://localhost:80'));
    }

}