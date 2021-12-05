<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

class OrderItem extends AbstractModel {

    use SoftDelete;
    
    /**
     * Da die Methode getTablenameFromClassname in diesem Fall nicht funktioniert, 
     * weil die Tabelle nicht order_items heißt, definierten wir selber den Namen.
     */
    public const TABLENAME = 'order_item';

    public function __construct(
        /**
         * Hier definieren wir alle Spalten aus der Tabelle mit dem richtigen Datentyp.
         */
        public ?int $id = null,
        public ?int $order_id = null,
        public ?int $product_id = null,
        public ?int $quantitiy = null,
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
            /**
             * Query ausführen und Ergebnis direkt zurückgeben. (true -> hat funktioniert, false -> nicht funktioniert)
             */
            $result = $database->query(
                "UPDATE $tablename SET order_id = ?, product_id = ?, quantity = ?, price = ? WHERE id = ?",
                [
                    'i:order_id' => $this->order_id,
                    'i:product_id' => $this->product_id,
                    'i:quantity' => $this->quantity,
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
                "INSERT INTO $tablename SET order_id = ?, product_id = ?, quantity = ?, price = ?",
                [
                    'i:order_id' => $this->order_id,
                    'i:product_id' => $this->product_id,
                    'i:quantity' => $this->quantity,
                    'd:price' => $this->price
                ]
            );

            /**
             * Ein INSERT Query generiert eine neue id, diese müssen wir daher extra abfragen und verwenden daher die
             * von uns geschrieben handleInsertResult()-Methode, die über das AbstractModel verfügbar ist.
             */
            $this->handleInsertResult($database);

            /**
             * Ergebnis true -> hat funktioniert, false -> nicht funktioniert
             */
            return $result;
        }
    }
}