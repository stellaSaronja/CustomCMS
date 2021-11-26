<?php

namespace App\Models;

use Core\Database;
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

    public function save(): bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if (!empty($this->id)) {
            $result = $database->query(
                "UPDATE $tablename SET username = ?, name = ?, surname = ?, email = ?, password = ? WHERE id = ?",
                [
                    's:username' => $this->username,
                    's:name' => $this->name,
                    's:surname' => $this->surname,
                    's:email' => $this->email,
                    's:password' => $this->password,
                    'i:id' => $this->id
                ]
            );

            return $result;
        } else {
            $result = $database->query("INSERT INTO $tablename SET username = ?, name = ?, surname = ?, email = ?, password = ?", [
                's:username' => $this->username,
                's:name' => $this->name,
                's:surname' => $this->surname,
                's:email' => $this->email,
                's:password' => $this->password
            ]);

            $this->handleInsertResult($database);

            return $result;
        }
    }
}