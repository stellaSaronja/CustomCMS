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
        } else {
            foreach ($this->routes as $route => $_callable) {
                if (str_contains($route, '{')) {
                    $regex = $this->buildRegex($route);

                    $matches = [];

                    if (preg_match_all($regex, $path, $matches, PREG_SET_ORDER) >= 1) {
                        $callable = $_callable;

                        foreach ($this->paramNames as $paramName) {
                            $params[$paramName] = $matches[0][$paramName];
                        }

                        break;
                    }
                }
            }
        }

        if (empty($callable)) {
            throw new \Exception('Not Found', 404);
        } else {
            /**
             * Controller und Action aus dem Callable laden und den Controller instanziieren.
             * $callable beinhaltete den Namen der Klasse inklusive Namespace als String und kann verwendet werden um
             * ein Objekt ohne fix definierten Klassennamen zu erzeugen, dynamisch also.
             */
            $controller = new $callable[0]();
            $action = $callable[1];

            /**
             * Nun rufen wir Controller und Action auf und verwenden den Spread Operator, weil wir mit einer
             * variablen Anzahl an Parametern umgehen müssen.
             */
            $controller->$action(...$params);
        }
    }

    private function buildRegex(string $route): string
    {
        /**
         * Um benannte Capture Groups erstellen zu können, müssen wir zunächst die Namen aller Parameter aus der Route
         * extrahieren. Das geht am einfachsten mit einer Regular Expression, die alles in der Form {xyz} sucht und den
         * Inhalt der Klammern in $matches schreibt.
         */
        $matches = [];
        preg_match_all('/{([a-zA-Z0-9]+)}/', $route, $matches);
        $this->paramNames = $matches[1];

        /**
         * Wir würden gerne den sehr einfachen Ausdruck aus unserem Routes File in eine valide Regular Expression
         * in der Form ^\/blog\/(?<paramName>[^\/]+)$ umformen. Dazu sind folgende Schritte notwenig:
         * - Slashes escapen (/ => \/)
         * - {param} mit einer Named Capture Group ersetzen
         * - Anfang und Ende des String setzen
         */
        $regex = str_replace('/', '\/', $route); // => '\/channels\/{id}'

        /**
         * Alle Parameter Namen durchgehen und innerhalb der $regex mit einer benannten Capture Group ersetzen, damit
         * am Ende eine valide Regular Expression raus kommt.
         */
        foreach ($this->paramNames as $paramName) {
            /**
             * {slug} => (?<slug>[^\/]+)
             * führt zu:
             * \/blog\/{slug} => \/blog\/(?<slug>[^\/]+)
             */
            $regex = str_replace("{{$paramName}}", "(?<$paramName>[^\/]+)", $regex); // => '\/channels\/(?<id>[^\/]+)'
        }

        /**
         * Anfang und Ende des Strings setzen und Regular Expression damit finalisieren.
         *
         * \/blog\/(?<slug>[^\/]+) => /^\/blog\/(?<slug>[^\/]+)$/
         */
        $regex = "/^$regex$/"; // => '/^\/channels\/(?<id>[^\/]+)$/'

        /**
         * Fertige Regular Expression zurückgeben
         */
        return $regex;
    }
}