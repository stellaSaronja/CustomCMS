<?php

namespace Core\Helpers;

class Redirector {

    public static function redirect(?string $redirect = null, bool $useBaseUrl = true) {
        if (!empty($redirect)) {

            if ($useBaseUrl === true) {
                header("Location" . BASE_URL . "$redirect");
                exit;
            }

            header("Location: $redirect");
            exit;
        }
    }
}