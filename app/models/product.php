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
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

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
            $result = $database->query("INSERT INTO $tablename SET name = ?, description = ?, category = ?, id = ?", [
                's:name' => $this->name,
                's:description' => $this->description,
                's:category' => $this->category,
                'i:id' => $this->id,
            ]);

            $this->handleInsertResult($database);

            return $result;
        }
    }

    // public function addImages(array $images): array
    // {
    //     $currentImages = $this->getImages();
    //     $currentImages = array_merge($currentImages, $images);
    //     $this->setImages($currentImages);

    //     return $currentImages;
    // }

    // public function getImages(): array
    // {
    //     return json_decode($this->images);
    // }

    // public function hasImages(): bool
    // {
    //     return !empty($this->getImages());
    // }

    // public function removeImages(array $images): array
    // {
    //     $currentImages = $this->getImages();

    //     $filteredImages = array_filter($currentImages, function ($image) use ($images) {
    //         if (in_array($image, $images)) {
    //             return false;
    //         }
    //         return true;
    //     });
    //     /**
    //      * @todo: objasniti
    //      */
    //     $this->setImages($filteredImages);

    //     return $filteredImages;
    // }

    // public function setImages(array $images): array
    // {
    //     $this->images = json_encode(array_values($images));

    //     return $this->getImages();
    //     /**
    //      * @todo: objasniti
    //      */
    // }
}