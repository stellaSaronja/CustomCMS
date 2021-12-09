<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractUser;
use Core\Traits\SoftDelete;

class User extends AbstractUser {
    
    use SoftDelete;

    /**
     * Da die Methode getTablenameFromClassname in diesem Fall nicht funktioniert, 
     * weil die Tabelle nicht users heißt, definierten wir selber den Namen.
     */
    const TABLENAME = 'user';

    public function __construct(
        public ?int $id = null,
        public string $username = '',
        public string $name = '',
        public string $surname = '',
        public string $email = '',
        protected string $password = '',
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null,
        public ?bool $is_admin = false
    ) {
    }

    /**
     * Objekt speichern.
     */
    public function save(): bool {
        /**
         * Datenbankverbindung herstellen.
         */
        $database = new Database();
        /**
         * Tabellennamen berechnen.
         */
        $tablename = self::getTablenameFromClassname();

        /**
         * Hat das Objekt bereits eine id, heißt das, dass es in der Datenbank schon existiert und 
         * wir können es aktualisieren.
         */
        if (!empty($this->id)) {
            /**
             * Query ausführen und Ergebnis direkt zurückgeben. Das kann entweder true oder false sein, je nachdem ob
             * der Query funktioniert hat oder nicht.
             */
            $result = $database->query(
                "UPDATE $tablename SET username = ?, name = ?, surname = ?, email = ?, password = ?, is_admin = ? WHERE id = ?",
                [
                    's:username' => $this->username,
                    's:name' => $this->name,
                    's:surname' => $this->surname,
                    's:email' => $this->email,
                    's:password' => $this->password,
                    'i:is_admin' => $this->is_admin,
                    'i:id' => $this->id
                ]
            );
            return $result;
        } else {
            /**
             * Hat das Objekt keine id, so müssen wir es neu anlegen.
             */
            $result = $database->query("INSERT INTO $tablename SET username = ?, name = ?, surname = ?, email = ?, password = ?, is_admin = ?", [
                's:username' => $this->username,
                's:name' => $this->name,
                's:surname' => $this->surname,
                's:email' => $this->email,
                's:password' => $this->password,
                'i:is_admin' => $this->is_admin
            ]);

            /**
             * Ein INSERT Query generiert eine neue id, diese müssen wir daher extra abfragen und verwenden daher die
             * von uns geschrieben handleInsertResult()-Methode, die über das AbstractModel verfügbar ist.
             */
            $this->handleInsertResult($database);

            /**
             * Ergebnis zurückgeben. Das kann entweder true oder false sein, je nachdem ob der Query funktioniert hat
             * oder nicht.
             */
            return $result;
        }
    }
}