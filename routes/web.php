<?php

use App\Controllers\HomeController;

return [

    '/' => [HomeController::class, 'index'],

    '/products' => [ProductController::class, 'index']
    
];