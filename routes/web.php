<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;

return [
    
    /**
     * Index Route
     */
    '/' => [HomeController::class, 'home'],

    /**
     * Home Route
     */
    '/home' => [HomeController::class, 'home'],

    /**
     * Auth Routes
     */
    '/login' => [AuthController::class, 'loginForm'],
    '/login/do' => [AuthController::class, 'loginDo'],
    '/logout' => [AuthController::class, 'logout'],
    '/sign-up' => [AuthController::class, 'signupForm'],
    '/sign-up/do' => [AuthController::class, 'signupDo'],

    /**
     * Products Routes
     */
    '/products' => [ProductController::class, 'index'],
    '/products/{id}/show' => [ProductController::class, 'show'],
    '/products/{id}' => [ProductController::class, 'edit'],
    '/products/{id}/update' => [ProductController::class, 'update'],
    '/products/{id}/delete' => [ProductController::class, 'delete'],
    '/products/create' => [ProductController::class, 'create'],
    '/products/store' => [ProductController::class, 'store'],

    /**
     * Cart Routes
     */
    '/cart' => [CartController::class, 'index'],
    '/products/{id}/add-to-cart' => [CartController::class, 'add'],
    '/products/{id}/remove-from-cart' => [CartController::class, 'remove'],
    '/products/{id}/remove-all-from-cart' => [CartController::class, 'removeAll'],
    
    /**
     * Checkout Routes
     */
    '/checkout' => [OrderController::class, 'summary'],
    '/checkout/saveOrder' =>  [OrderController::class, 'saveOrder'],
    '/validateOrder' => [CartController::class, 'validateOrder']
];