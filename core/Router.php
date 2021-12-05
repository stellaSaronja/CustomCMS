<?php

namespace Core;

class Router {

    /**
     * Wird alle Routen, die das System kennt, beinhalten.
     */
    private array $routes = [];

    /**
     * Beinhaltet die Namen der Parameter für die gefundenen Route.
     */
    private array $paramNames = [];

    /**
     * Routen automatisiert laden.
     */
    public function __construct() {
        $this->loadRoutes();
    }

    /**
     * Routen laden
     */
    private function loadRoutes() {
        /**
         * Route-Files laden.
         */
        $webRoutes = require_once __DIR__ . '/../routes/web.php';

        /**
         * Property setzen, damit die Routen in diesem Objekt immer überall verfügbar sind.
         */
        $this->routes = $webRoutes;
    }

    public function route() {
        /**
         * $_GET['path'] so umformen, dass immer ein führendes Slash dran steht und am Ende keines.
         */
        $path = '';
        if (isset($_GET['path'])) {
            $path = $_GET['path'];
        }

        /**
         * `rtrim()` entfernt eine Liste an Zeichen vom Ende eines Strings.
         *
         * Unsere Standard Route ist nur /.
         */
        $path = '/' . rtrim($path, '/');

        /**
         * Variablen initialisieren, damit wir sie später befüllen können.
         */
        $callable = [];
        $params = [];

        /**
         * Prüfen, ob der angefragte Pfad als Route in unseren Routen 1:1 vorkommt oder nicht.
         */
        if (array_key_exists($path, $this->routes)) {
            $callable = $this->routes[$path];
        } else {
            /**
             * Wurde die Route im if-Block nicht gefunden, so bedeutet das, dass ein Parameter in der Route vorkommt,
             * der im angefragten Pfad bereits mit einem Wert belegt ist. Wir müssen nun also alle Routen durchgehen und
             * prüfen, ob eine Route auf den angegebenen Pfad passt.
             */
            foreach ($this->routes as $route => $_callable) {
                /**
                 * Wenn eine Route eine geschwungene Klammer beinhaltet, gibt es einen Parameter und wir formen sie in
                 * eine valide Regular Expression um. Wenn Sie keine geschwungene Klammer beinhaltet, dann beinhaltet
                 * sie auch keinen Parameter, wurde im oben stehenden if-Block bereits abgedeckt und braucht nicht
                 * umgeformt zu werden.
                 */
                if (str_contains($route, '{')) {
                    /**
                     * Route in eine Regular Expression umformen.
                     */
                    $regex = $this->buildRegex($route);

                    /**
                     * Beinhaltet die einzelnen Treffer der Regular Expression.
                     */
                    $matches = [];

                    /**
                     * Hier prüfen wir, ob der angefragte Pfad auf die Route im aktuellen Schleifendurchlauf zutrifft.
                     */
                    if (preg_match_all($regex, $path, $matches, PREG_SET_ORDER) >= 1) {
                        /**
                         * $_callable kommt aus der for-Schleife.
                         */
                        $callable = $_callable;

                        /**
                         * Damit wir die Parameter mit Namen und Werten extrahieren können, gehen wir alle in
                         * $this->buildRegex() aus der Route extrahierten Parameter Namen durch und holen den
                         * zugehörigen Wert aus $matches.
                         */
                        foreach ($this->paramNames as $paramName) {
                            $params[$paramName] = $matches[0][$paramName];
                        }

                        /**
                         * Break beendet die aktuelle Schleife, weil wir nur einen Treffer brauchen.
                         */
                        break;
                    }
                }
            }
        }

        /**
         * Wenn kein Controller gefunden wurde ...
         */
        if (empty($callable)) {
            /**
             * ... werfen wir eine Exception, die im Router gecatcht wird und über den ErrorHandler dann ausgegeben.
             */
            throw new \Exception('Not Found', 404);
        } else {
            /**
             * Controller und Action aus dem Callable laden und den Controller instanziieren.
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

    private function buildRegex(string $route): string {
        /**
         * Um benannte Capture Groups erstellen zu können, müssen wir die Namen aller Parameter aus der Route extrahieren.
         */
        $matches = [];
        preg_match_all('/{([a-zA-Z0-9]+)}/', $route, $matches);
        $this->paramNames = $matches[1];

        /**
         * Ausdruck aus dem Routes File in eine valide Regular Expression umformen.
         */
        $regex = str_replace('/', '\/', $route);

        /**
         * Alle Parameter Namen durchgehen und innerhalb der $regex mit einer benannten Capture Group ersetzen, damit
         * am Ende eine valide Regular Expression raus kommt.
         */
        foreach ($this->paramNames as $paramName) {
            $regex = str_replace("{{$paramName}}", "(?<$paramName>[^\/]+)", $regex); // => '\/channels\/(?<id>[^\/]+)'
        }

        /**
         * Anfang und Ende des Strings setzen und Regular Expression damit finalisieren.
         */
        $regex = "/^$regex$/";

        /**
         * Fertige Regular Expression zurückgeben
         */
        return $regex;
    }
}