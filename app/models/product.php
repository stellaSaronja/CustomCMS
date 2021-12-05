<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractModel;
use Core\Traits\SoftDelete;

class Product extends AbstractModel {

    use SoftDelete;

    public function __construct(
        public ?int $id = null,
        public string $name = '',
        public string $description = '',
        public string $category = '',
        public string $price = '',
        public string $images = '[]',
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null
    ) {
    }

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
         * Hat das Objekt bereits eine id, so existiert in der Datenbank auch schon ein Eintrag dazu und wir können es
         * aktualisieren.
         */
        if (!empty($this->$id)) {
           $result = $database->query(
                "UPDATE $tablename SET name = ?, description = ?, category = ?, price = ?, images = ? WHERE id = ?",
                [
                    's:name' => $this->name,
                    's:description' => $this->description,
                    's:category' => $this->category,
                    's:price' => $this->price,
                    's:images' => $this->images,
                    'i:id' => $this->id
                ]
            );
            return $result;
        } else {
            /**
             * Hat das Objekt keine id, so müssen wir es neu anlegen.
             */
            $result = $database->query("INSERT INTO $tablename SET name = ?, description = ?, category = ?, id = ?", [
                's:name' => $this->name,
                's:description' => $this->description,
                's:category' => $this->category,
                'i:id' => $this->id,
            ]);

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