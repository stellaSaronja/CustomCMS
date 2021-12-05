<?php

namespace Core;

class ExceptionHandler {

    /**
     * Fehler in einem catch-Block entgegennehmen und exception view laden.
     */
    public static function handle(\Exception $exception) {
        /**
         * View laden und Werte aus der Exception übergeben.
         */
        View::error('errors/exception', [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ], httpResponseCode: $exception->getCode() );
    }
}