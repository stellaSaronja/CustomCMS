<?php

namespace App\Models;

use Core\Database;
use Core\Traits\SoftDelete;

class Product {

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
        /**
         * @todo: uskladiti sa Database-om
         */
    ) {
    }
}