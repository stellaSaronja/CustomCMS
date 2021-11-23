<?php

namespace Core\Models;

use Core\Database;

abstract class AbstractModel {

    public abstract function save(): bool;

    public static function all(?string $orderBy = null, ?string $direction = null): array {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if ($orderBy === null) {
            $result = query("SELECT * FROM $tablename");
        } else {
            $result = query("SELECT * FROM $tablename ORDER BY $orderBy $direction");
        }

        return self::handleResult($result);
    }

    public static function find(int $id): ?object {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        $result = $database->query("SELECT * FROM $tablename WHERE `id` = ?", ['i:id' => $id]);

        return self::handleUniqueResult($result);
    }

    public static function findOrFail(int $id): ?object {
        $result = self::find($id);

        if (empty($result)) {
            throw new Exception("Model not found", 404);
            /**
             * @todo: napraviti exception
             */
        }

        return $result;
    }

    public function fill(array $data, bool $ignoreEmpty): object {
        foreach ($data as $name => $value) {
            if (property_exists($this, $name)) {
                $trimmedValue = trim($value);

                if ($ignoreEmpty !== true || !empty($value)) {
                    $this->$name = $trimmedValue;
                }
            }
        }

        return $this;
    }

    public function delete(): bool {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        $result = query("DELETE FROM $tablename WHERE id = ?", ['i:id' => $this->id]);

        return $result;
    }

    public static function handleResult(array $results): array {
        $objects = [];

        foreach ($results as $result) {
            $calledClass = get_called_class();
            $objects[] = new $calledClass(...$result);
            /**
             * @todo: objasniti
             */
        }

        return $objects;
    }

    public static function handleUniqueResult(array $results): ?object {
        $objects = self::handleResult($results);

        if (empty($objects)) {
            return null;
        }

        return $objects[0];
    }

    public function handleInsertResult(Database $database)
    {
        $newId = $database->getInsertId();

        if (is_int($newId)) {
            $this->id = $newId;
        }
    }

    public static function getTablenameFromClassname(): string {
        $calledClass = get_called_class();

        if (defined("$calledClass::TABLENAME")) {
            return $calledClass::TABLENAME;
            /**
             * @todo: objasniti
             */
        }

        $splitName = explode('\\', $calledClass);
        $classname = array_pop($splitName);
        $tablename = strtolower($classname) . 's';

        return $tablename;
    }
}