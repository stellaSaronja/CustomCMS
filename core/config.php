<?php

namespace Core;

/**
 * Class Config
 */
class Config {

    public static function get (string $filenameAndKey, mixed $default = null): mixed {
        /**
         * Dateiname und Config-Key aus dem $configString auslesen. Hier verwenden wir Array Destructuring um beide
         * Variablen direkt setzen zu können.
         */
        [$filename, $key] = explode('.', $filenameAndKey);

        /**
         * Config filename generieren
         */
        $path = __DIR__ . "/../config/$filename.php";

        /**
         * Existiert die gewünschte Config-Datei?
         */
        if (file_exists($path)) {
            $config = require $path;

            /**
             * Wenn der Config-Key in dem entsprechenden File existiert, dann geben wir den Wert davon zurück, sonst
             * geben wir den Wert von $default zurück.
             */
            if (array_key_exists($key, $config)) {
                return $config[$key];
            }
        }

        /**
         * Standardwert zurückgeben, wenn das File nicht existiert oder der angegeben Key nicht existiert.
         */
        return $default;
    }

}
