<?php

namespace Core;

class Config {
    public static function get(string $filenameAndKey, mixed $default = null): mixed
    {
        [$filename, $key] = explode('.', $filenameAndKey);

        $path = __DIR__ . "/../config/$filename.php";

        if (file_exists($path)) {
            $config = require $path;

            if (array_key_exists($key, $config)) {
                return $config[$key];
            }
        }

        return $default;
    }
}