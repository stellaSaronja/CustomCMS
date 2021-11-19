<?php

namespace Core\Helpers;

class Redirector {

    public static function redirect(?string $redirect = null, bool $baseUrl = true) {
        if (!empty($redirect)) {

            if ($baseUrl === true) {
                header("Location" . BASE_URL . "$redirect");
                /**
                 * @todo: objasniti
                 */
            }

            header("Location: $redirect");
            exit;
        }
    }
}