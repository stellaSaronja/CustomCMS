<?php

namespace App\Models;

use Core\Models\AbstractUser;
use Core\Traits\SoftDelete;

class User extends AbstractUser {

    use SoftDelete;

    const TABLENAME = 'user';

    public function __construct(
        public ?int $id = null,
        public string $username,
        public string $name,
        public string $surname,
        public string $email,
        protected string $password,
        public string $created_at,
        public string $updated_at,
        public ?string $deleted_at = null
    ) {
    }

    public function save(): bool {
    }
}