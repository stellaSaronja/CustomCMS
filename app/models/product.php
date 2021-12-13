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
        if (!empty($this->id)) {
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
            $result = $database->query("INSERT INTO $tablename SET name = ?, description = ?, category = ?, price = ?, images = ?", [
                's:name' => $this->name,
                's:description' => $this->description,
                's:category' => $this->category,
                's:price' => $this->price,
                's:images' => $this->images
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

    /**
     * Getter für Images.
     */
    public function getImages(): array
    {
        /**
         * Nachdem $this->images ein JSON-Array ist, wandeln wir ihn hier in ein natives PHP Array um.
         */
        return json_decode($this->images);
    }

    /**
     * Ein oder mehrere Bilder in $this->images hinzufügen.
     */
    public function addImages(array $images): array
    {
        /**
         * Zunächst holen wir uns die aktuelle Liste verknüpfter Bilder des Raumes als Array, ...
         */
        $currentImages = $this->getImages();
        /**
         * ... führen sie dann mit der Liste der hinzuzufügenden Bilder zusammen ...
         */
        $currentImages = array_merge($currentImages, $images);
        /**
         * ... und überschreiben die aktuelle Liste.
         */
        $this->setImages($currentImages);

        /**
         * Zum Abschluss geben wir die neue Liste der Bilder zurück.
         */
        return $currentImages;
    }

    /**
     * Ein oder mehrere Bilder aus den verknüpften Bildern des Raumes entfernen.
     */
    public function removeImages(array $images): array
    {
        /**
         * Zunächst holen wir uns die aktuelle Liste verknüpfter Bilder des Raumes als Array.
         */
        $currentImages = $this->getImages();
        /**
         * Nun filtern wir alle Bilder mit einer Callback-Funktion.
         */
        $filteredImages = array_filter($currentImages, function ($image) use ($images) {
            /**
             * Ein Element wird in das Ergebnis-Array übernommen, wenn die Callback Funktion true zurück gibt. Soll ein
             * Bild also entfernt werden, geben wir false zurück.
             */
            if (in_array($image, $images)) {
                return false;
            }
            return true;
        });

        /**
         * Nun überschreiben wir die aktuelle Liste verknüpfter Bilder des Raumes.
         */
        $this->setImages($filteredImages);

        return $filteredImages;
    }

    /**
     * Setter für Images.
     */
    public function setImages(array $images): array
    {
        /**
         * Hier indizieren wir das $images Array neu und konvertieren es in ein JSON. Das ist nötig, weil die JSON-
         * Konvertierung sonst ein Objekt und kein Array erzeugen würde - daher stellen wir sicher, dass die Arrray-
         * Indizes fortlaufend sind.
         */
        $this->images = json_encode(array_values($images));

        /**
         * Zum Abschluss geben wir die neue Liste der verknüpften Bilder zurück.
         */
        return $this->getImages();
    }
}