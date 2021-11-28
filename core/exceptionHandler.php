<?php

namespace Core;

class ExceptionHandler {

    public static function handle(\Exception $exception) {
        View::error('errors/exception', [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ], httpResponseCode: $exception->getCode() );
    }
}