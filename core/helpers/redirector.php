<?php

namespace Core\Helpers;

class Redirector {

    public static function redirect(?string $redirect = null, bool $useBaseUrl = true) {
        /**
         * Wurde eine Redirect-URL übergeben, leiten wir hier weiter.
         */
        if (!empty($redirect)) {
            /**
             * Das übergebene Redirect-Ziel mit der BASE_URL prefixen
             */
            if ($useBaseUrl === true) {
                header("Location: " . BASE_URL . "$redirect");
                exit;
            }

            /**
             * Wenn kein prefixing benötigt wird, leiten wir ohne Änderung weiter.
             */
            header("Location: $redirect");
            exit;
        }
    }
}