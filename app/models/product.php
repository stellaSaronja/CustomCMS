<?php

namespace App\Models;

use Core\Database;
use Core\Traits\SoftDelete;

class Product {

    use SoftDelete;

    public function __construct(
        public ?int $id = null,
        public string $name = '',
        public ?string $location = null,
        public string $room_nr = '',
        public string $images = '[]',
        public string $created_at = '',
        public string $updated_at = '',
        public ?string $deleted_at = null,
        private array $_roomFeatures = []
        /**
         * @todo: uskladiti sa Database-om
         */
    ) {
    }
}