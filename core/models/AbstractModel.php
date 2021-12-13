<?php

namespace Core\Models;

use Core\Database;
use Exception;

abstract class AbstractModel {

    /**
     * Hier definieren wir, dass jede Class, die das AbstractModel erweitert, auch eine save()-Methode definieren muss.
     */
    public abstract function save(): bool;

    /**
     * Alle Datensätze aus der Datenbank abfragen.
     */
    public static function all(?string $orderBy = null, ?string $direction = null): array {
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
            $result = $database->query("SELECT * FROM $tablename");
        } else {
            $result = $database->query("SELECT * FROM $tablename ORDER BY $orderBy $direction");
        }

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return self::handleResult($result);
    }

    /**
     * Ein einzelnes Objekt anhand seiner ID finden
     */
    public static function find(int $id): ?object {
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
        $result = $database->query("SELECT * FROM $tablename WHERE `id` = ?", [
            'i:id' => $id
        ]);

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return self::handleUniqueResult($result);
    }

    /**
     * find()-Methode aufrufen oder einen Fehler 404 Not Found zurückgeben, wenn kein Ergebnis aus der Datenbank
     * zurückgekommen ist.
     */
    public static function findOrFail(int $id): ?object {
        /**
         * find()-Methode aufrufen.
         */
        $result = self::find($id);

        if (empty($result)) {
            /**
             * Wurde kein Ergebnis gefunden, so werfen wir einen Fehler, den wir über den ErrorHandler dann abfangen können.
             */
            throw new Exception('Model not found', 404);
        }

        /**
         * Wurde ein Ergebnis gefunden, so geben wir es zurück.
         */
        return $result;
    }

    /**
     * Jedes beliebige Model, das das AbstractModel erweitert, mit Daten aus einem Array (bspw. $_GET oder $_POST) zu befüllen.
     */
    public function fill(array $data, bool $ignoreEmpty = true): object {
        /**
         * Wir gehen alle Werte aus dem übergebenen Array durch.
         */
        foreach ($data as $name => $value) {
            /**
             * Existiert zu dem Wert eine namensgleiche Property in dem Objekt ...
             */
            if (property_exists($this, $name)) {
                /**
                 * ... so trimmen wir den Wert.
                 */
                $trimmedValue = trim($value); 

                /**
                 * Ist der getrimmte Wert nicht leer oder möchten wir leere Werte nicht ignorieren, so überschreiben
                 * wir die Property mit dem Wert aus dem Array.
                 */
                if ($ignoreEmpty !== true || !empty($value)) {
                    $this->$name = $trimmedValue;
                }
            }
        }

        /**
         * Nun geben wir das aktualisierte Objekt zurück.
         */
        return $this;
    }

    /**
     * Objekt löschen.
     */
    public function delete(): bool {
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
        $result = $database->query("DELETE FROM $tablename WHERE id = ?", [
            'i:id' => $this->id
        ]);

        /**
         * Datenbankergebnis verarbeiten und zurückgeben.
         */
        return $result;
    }

    /**
     * Resultat aus der Datenbank verarbeiten.
     */
    public static function handleResult(array $results): array {
        /**
         * Ergebnis-Array vorbereiten.
         */
        $objects = [];

        /**
         * Ergebnisse des Datenbank-Queries durchgehen und jeweils ein neues Objekt erzeugen.
         */
        foreach ($results as $result) {
            /**
             * Auslesen, welche Klasse aufgerufen wurde und ein Objekt dieser Klasse erstellen und in den Ergebnis-Array speichern.
             */
            $calledClass = get_called_class();
            $objects[] = new $calledClass(...$result);
        }

        /**
         * Ergebnisse zurückgeben.
         */
        return $objects;
    }

    /**
     * Erweiterte handleResult-Methode für den Fall, dass wir von einem Query kein oder maximal ein Ergebnis erwarten.
     */
    public static function handleUniqueResult(array $results): ?object {
        /**
         * Datenbankergebnis verarbeiten.
         */
        $objects = self::handleResult($results);

        /**
         * Ergebnis aus der Datenbank leer => null
         */
        if (empty($objects)) {
            return null;
        }

        /**
         * Andernfalls geben wir das Objekt an Stelle 0 zurück.
         */
        return $objects[0];
    }

    /**
     * Wenn ein INSERT-Query ausgeführt wird, wird eine neue ID generiert. Das Objekt wird mit der neuen ID aktualisiert.
     */
    public function handleInsertResult(Database $database) {
        /**
         * Neu generierte ID holen.
         */
        $newId = $database->getInsertId();

        /**
         * Handelt es sich um einen Integer und wurde somit eine neue id vergeben ...
         */
        if (is_int($newId)) {
            /**
             * ... aktualisieren wir das aktuelle Objekt mit diesem Wert.
             */
            $this->id = $newId;
        }
    }

    /**
     * Damit diese abstrakte Klasse für alle Models verwendet werden kann, ist es hilfreich, berechnen zu können, welche
     * Tabelle vermutlich zu dem erweiternden Model gehört.
     */
    public static function getTablenameFromClassname(): string {
        /**
         * Name der aufgerufenen Klasse abfragen.
         */
        $calledClass = get_called_class();

        /**
         * Wenn die aufgerufene Klasse eine Konstante TABLENAME hat, dann verwenden wir diese Konstante als Tabellenname.
         */
        if (defined("$calledClass::TABLENAME")) {
            return $calledClass::TABLENAME;
        }

        /**
         * Wenn nein, dann holen wir uns den Namen der Klasse ohne Namespace, konvertieren ihn in Kleinbuchstaben und
         * fügen hinten ein s dran. So wird bspw. aus App\Models\Product -> products
         */
        $particles = explode('\\', $calledClass);
        $classname = array_pop($particles);
        $tablename = strtolower($classname) . 's';

        /**
         * Berechneten Tabellennamen zurückgeben.
         */
        return $tablename;
    }
}