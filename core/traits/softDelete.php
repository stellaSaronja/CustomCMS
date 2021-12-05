<?php

namespace Core\Traits;

use Core\Database;

trait SoftDelete
{

    /**
     * Den zum aktuellen Objekt gehörigen Datensatz in der Datenbank als gelöscht markieren.
     */
    public function delete(): bool
    {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::getTablenameFromClassname();

        /**
         * Query ausführen.
         */
        $result = $database->query("UPDATE $tablename SET deleted_at = CURRENT_TIME() WHERE id = ?", [
            'i:id' => $this->id
        ]);

        /**
         * Datenbankergebnis zurückgeben.
         */
        return $result;
    }

    /**
     * Alle Datensätze aus der Datenbank abfragen.
     */
    public static function all(?string $orderBy = null, ?string $direction = null): array
    {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::getTablenameFromClassname();

        /**
         * Query ausführen.
         */
        if ($orderBy === null) {
            $result = $database->query("SELECT * FROM $tablename WHERE deleted_at IS NULL");
        } else {
            $result = $database->query(
                "SELECT * FROM $tablename WHERE deleted_at IS NULL ORDER BY $orderBy $direction"
            );
        }

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return self::handleResult($result);
    }
}