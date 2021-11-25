<?php

use App\Controllers\HomeController;
use App\Controllers\ProductController;

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
    '/products/{id}/show' => [ProductController::class, 'show']
    
];