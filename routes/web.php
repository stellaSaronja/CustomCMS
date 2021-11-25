<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
return [
    '/' => [HomeController::class, 'home'],

    /**
     * Home Route
     */
    '/home' => [HomeController::class, 'home'],

    /**
     * Users Routes
     */
    '/users' => [UserController::class, 'index'],
    '/users/{id}/show' => [UserController::class, 'show'],
    /**
    *'/users/{id}/update' => [UserController::class, 'update'],
    *'/users/{id}/delete' => [UserController::class, 'delete'],
    *'/users/{id}/delete/confirm' => [UserController::class, 'deleteConfirm'],
    *'/users/create' => [UserController::class, 'create'],
    *'/users/store' => [UserController::class, 'store'],
    */
    /**
     * Product Routes
     */
    '/products' => [ProductController::class, 'index']
];