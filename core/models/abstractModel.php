<?php

namespace Core\Models;

abstract class AbstractModel {

    public abstract function save(): bool;

    public static function all(?string $orderBy = null, ?string $direction = null): array {
        $database = new Database;

        $tablename = self::getTablenameFromClassname();

        if ($orderBy === null) {
            $result = query("SELECT * FROM $tablename");
        } else {
            $result = query("SELECT * FROM $tablename ORDER BY $orderBy $direction");
        }

        return self::handleResult($result);
        /**
         * @todo: napraviti funkciju handleResult, query, getTablenameFromClassname
         */
    }
}