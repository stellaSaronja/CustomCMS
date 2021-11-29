<?php

namespace Core;

class Bootloader {

    public function __construct(){
        Session::init();

        Session::initSuperGlobals();

        define('BASE_URL', Config::get('app.baseurl'));
        define('IMG_FOLDER_URL', Config::get('app.images_folder_url'));

        try {
            $router = new Router();
            $router->route();
        } catch (\Exception $exception) {
            /**
             * Ist innerhalb des try-Blocks eine Exception aufgetreten (auch innerhalb von Funktionen, die in dem Block
             * aufgerufen wurden), so wird diese Exception hier an unseren ErrorHandler übergeben. Dadurch haben wir
             * einen einzigen Handler für alle Exceptions, die in Controllern auftreten könnten.
             *
             * Exceptions selbst sind Fehler im System, die das System in einen Zustand bringen, an dem es nicht mehr
             * weiter kommt. Wenn keine Route gefunden wird, kann man drüber diskutieren, aber eine Umsetzung als
             * Exception ist meines Erachtens nach durchaus legitim.
             */
            ExceptionHandler::handle($exception);
        }
    }

    public static function setDisplayErrors()
    {
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
             *
             * Hier werden zwei PHP Einstellungen überschrieben, die in der php.ini Datei konfiguriert sind.
             */
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            /**
             * E_ALL ist eine von PHP mitgelieferte Konstante zur Konfiguration. Hier wird definiert, dass wir ALLE
             * Fehler angezeigt bekommen möchten.
             */
            error_reporting(E_ALL);
        }
    }

}