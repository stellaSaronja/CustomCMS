<?php

namespace Core;

class Router {

    private array $routes = [];

    private array $paramNames = [];

    public function __construct() {
        $this->loadRoutes();
    }

    private function loadRoutes() {
        $webRoutes = require_once __DIR__ . '/../routes/web.php';
        $this->routes = $webRoutes;
    }

    public function route() {
        $path = '';
        if (isset($_GET['path'])) {
            $path = $_GET['path'];
        }

        $path = '/' . rtrim($path, '/');

        $callable = [];
        $params = [];

        if (array_key_exists($path, $this->routes)) {
            $callable = $this->routes[$path];
        }
    }
}