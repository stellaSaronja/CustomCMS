<?php

namespace Core;

class Bootloader {

    public function __construct() {
        /**
         * Session starten
         */
        Session::init();
        /**
         * Daten aus den $_GET und $_POST Superglobals in die Session speichern.
         */
        Session::initSuperglobals();

        /**
         * Hier definieren wir die BASE_URL als auch IMAGE_URL, damit wir nicht immer dieselben URLs schreiben müssen.
         */
        define('BASE_URL', Config::get('app.baseurl'));
        define('IMG_FOLDER_URL', Config::get('app.images_folder_url'));

        /**
         * Ein try-catch-Block ermöglicht es uns Code auszuführen und eine Exception, die in diesem Code auftritt
         * abzufangen, ohne dass der Skriptdurchlauf abgebrochen wird.
         */
        try {
            /**
             * Hier erstellen wir einen neuen Router und starten dann das Routing.
             */
            $router = new Router();
            $router->route();

        } catch (\Exception $exception) {
            /**
             * Ist innerhalb des try-Blocks eine Exception aufgetreten (auch innerhalb von Funktionen, die in dem Block
             * aufgerufen wurden), so wird diese Exception hier an den ErrorHandler übergeben.
             */
            ExceptionHandler::handle($exception);
        }
    }

    /**
     * Je nach Umgebung, welche Umgebung (dev/prod) gerade konfiguriert ist, schalten wir das error reporting ein oder
     * aus.
     */
    public static function setDisplayErrors() {
        /**
         * Config aus dem app.php Config File auslesen
         */
        $environment = Config::get('app.environment', 'prod');

        /**
         * Wenn grade die dev Environment konfiguriert ist ...
         */
        if ($environment === 'dev') {
            /**
             * ... zeigen wir alle Fehler an.
             */
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            /**
             * Hier wird definiert, dass wir ALLE Fehler angezeigt bekommen möchten.
             */
            error_reporting(E_ALL);
        }
    }
}