<?php

use App\Controllers\HomeController;
use App\Controllers\ProductController;

return [

    '/' => [HomeController::class, 'index'],

    '/products' => [ProductController::class, 'index']
    
];