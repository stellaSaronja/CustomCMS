<?php

namespace Core;

use mysqli;
use mysqli_result;

class Database {

    private object $link;
    private object $stmt;
    private mixed $lastResult;
    private array $data;

    public function __construct() {
        /**
         * Datenbankverbindung aufbauen
         */
        $this->link = new mysqli(
            Config::get('database.host'),
            Config::get('database.user'),
            Config::get('database.password'),
            Config::get('database.dbname'),
            Config::get('database.port', 3306),
            Config::get('database.socket')
        );

        /**
         * Charset für die Daten setzen.
         */
        $this->link->set_charset('utf8');
    }

    /**
     * Hier verwenden wir Prepared Statements, damit wir nicht jedes Mal die Parameter binden müssen.
     */
    public function query(string $query, array $params = []): bool|array {
        /**
         * Wenn keine Parameter in $params übergeben wurden an diese Funktion, dann schicken wir den Query einfach so ab,
         * weil wir ihn nicht preparen müssen.
         */
        if (empty($params)) {
            $this->lastResult = $this->executeQuery($query);
        } else {
            /**
             * Query als Prepared Statement verarbeiten.
             */
            $this->lastResult = $this->prepareStatementAndExecuteQuery($query, $params);
        }

        /**
         * Ist das Ergebnis false, was bei allen Queries außer SELECT-Queries der Fall ist, ...
         */
        if ($this->lastResult === false) {
            /**
             * ... so prüfen wir, ob ein Fehler aufgetreten ist oder nicht. Ist die Fehlernummer (errno) gleich 0,
             * ist kein Fehler aufgetreten und wir geben den positiven Wert true zurück, andernfalls false.
             */
            if ($this->stmt->errno === 0) {
                $this->lastResult = true;
            }
        }

        /**
         * Das Ergebnis ist nur dann ein bool'scher Wert, wenn ein Fehler auftritt oder ein Query ohne Ergebnis ausgeführt wird (z.B. DELETE).
         */
        if (is_bool($this->lastResult)) {
            return $this->lastResult;
        }

        /**
         * Tritt kein Fehler auf, erstellen wir ein assoziatives Array aus dem Datenbankergebnis ...
         */
        $this->data = $this->lastResult->fetch_all(MYSQLI_ASSOC);

        /**
         * ... und geben es zurück.
         */
        return $this->data;
    }

    /**
     * Datenbank-Query nicht als Prepared Statement ausführen.
     */
    private function executeQuery(string $query): mysqli_result|bool {
        return $this->link->query($query);
    }

    /**
     * Datenbank-Query als Prepared Statement ausführen.
     */
    private function prepareStatementAndExecuteQuery(string $queryWithPlaceholders, array $params): mysqli_result|bool {
        /**
         * Prepared Statement initialisieren
         */
        $this->stmt = $this->link->prepare($queryWithPlaceholders);

        /**
         * Variablen vorbereiten
         */
        $paramTypes = [];
        $paramValues = [];

        /**
         * Funktionsparameter $params durchgehen und die obenstehenden Variablen befüllen.
         */
        foreach ($params as $typeAndName => $value) {
            $paramTypes[] = explode(':', $typeAndName)[0];

            /**
             * $stmt->bind_param() erwartet eine Referenz als Werte und nicht eine normale Variable, daher müssen wir in
             * unseren $paramValues Array Referenzen pushen. Das ist eine seltsame aber begründete Eigenheit von
             * bind_param().
             */
            $_value = $value;
            $paramValues[] = &$_value;
            unset($_value);
        }

        /**
         * $stmt->bind_param() verlangt als ersten Parameter einen String mit den Typen aller folgenden Parameter. Wir
         * müssen also aus dem Array $paramTypes einen String erstellen.
         */
        $paramTypesString = implode('', $paramTypes);

        /**
         * Query fertig "preparen".
         */
        $this->stmt->bind_param($paramTypesString, ...$paramValues);
        /**
         * Query an den MySQL Server schicken.
         */
        $this->stmt->execute();

        /**
         * Ergebnis aus dem Query holen und zurückgeben.
         */
        return $this->stmt->get_result();
    }

    public function getLink(): mysqli {
        return $this->link;
    }

    public function getLastResult(): bool|array {
        return $this->lastResult;
    }

    public function getData(): array {
        return $this->data;
    }

    /**
     * Wird bei einem INSERT-Query ein auto_increment Feld befüllt, wird der Wert des zuletzt ausgeführten Queries in $link->insert_id gespeichert.
     */
    public function getInsertId(): int|string {
        return $this->link->insert_id;
    }
}