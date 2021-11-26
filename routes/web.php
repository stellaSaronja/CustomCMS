<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\UserController;

return [

    '/' => [HomeController::class, 'index'],

    /**
     * Home Route
     */
    '/home' => [HomeController::class, 'home'],

    /**
     * Products Routes
     */
    '/products' => [ProductController::class, 'index'],
    '/products/{id}/show' => [ProductController::class, 'show'],

    /**
     * Users Routes
     */
    '/users' => [UserController::class, 'index'],
    '/users/{id}/show' => [UserController::class, 'show'],
    
];