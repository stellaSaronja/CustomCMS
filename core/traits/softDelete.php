<?php

namespace Core\Traits;

use Core\Database;

trait SoftDelete {

    public function delete(): bool {
        $database = new Database();

        $tablename = self::getTablenameFromClass();

        $result = $database->query("UPDATE $tablename SET deleted_at = CURRENT_TIME() WHERE id = ?", ['i:id' => $this->id]);
        return $result;
    }

    public static function all(?string $orderBy = null, ?string $direction = null): array
    {
        $database = new Database();
        $tablename = self::getTablenameFromClassname();

        /**
         * Query ausführen.
         *
         * Wurde in den Funktionsparametern eine Sortierung definiert, so wenden wir sie hier an, andernfalls rufen wir
         * alles ohne Sortierung ab.
         *
         * Hier nehmen wir auch Rücksicht auf die deleted_at Spalte und geben nur Einträge zurück, die nicht als
         * gelöscht markiert sind.
         */
        if ($orderBy === null) {
            $result = $database->query("SELECT * FROM $tablename WHERE deleted_at IS NULL");
        } else {
            $result = $database->query(
                "SELECT * FROM $tablename WHERE deleted_at IS NULL ORDER BY $orderBy $direction"
            );
        }

        return self::handleResult($result);
    }
}