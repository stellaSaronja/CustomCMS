<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

class Order extends AbstractModel {

    use SoftDelete;

    public function __construct(
        /**
         * Hier definieren wir alle Spalten aus der Tabelle mit dem richtigen Datentyp.
         */
        public ?int $id = null,
        public ?int $user_id = null,
        public string $address = '',
        public string $payment_type = '',
        public ?string $price = null,
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null
    ) {
    }

    public function save(): bool
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
         * Hat das Objekt bereits eine id, so existiert in der Datenbank auch schon ein Eintrag dazu und wir können es
         * aktualisieren.
         */
        if (!empty($this->id)) {

            $result = $database->query(
                "UPDATE $tablename SET user_id = ?, address = ?, payment_type = ?, price = ? WHERE id = ?",
                [
                    'i:user_id' => $this->user_id,
                    's:address' => $this->address,
                    's:payment_type' => $this->payment_type,
                    'd:price' => $this->price,
                    'i:id' => $this->id
                ]
            );

            return $result;
        } else {
            /**
             * Hat das Objekt keine id, so müssen wir es neu anlegen.
             */
            $result = $database->query(
                "INSERT INTO $tablename SET user_id = ?, address = ?, payment_type = ?, price = ?",
                [
                    'i:user_id' => $this->user_id,
                    's:address' => $this->address,
                    's:payment_type' => $this->payment_type,
                    'd:price' => $this->price
                ]
            );
            $this->handleInsertResult($database);

            return $result;
        }
    }
}