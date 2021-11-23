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
            $this->saveProduct();
            /**
             * @todo: napraviti saveProduct funkciju
             */

            return $result;
        }
    }
}