<?php

namespace App\Modles;

use Core\Models\AbstractUser;
use Core\Traits\SoftDelete;

class User extends AbstractUser {

    use SoftDelete;

    public function __construct(
        public int $id,
        public string $username,
        public string $name,
        public string $surname,
        public string $email,
        protected string $password,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at
    ) {
    }

    public function save(): bool {
    }
}