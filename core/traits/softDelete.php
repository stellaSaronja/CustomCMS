<?php

namespace Core\Traits;

trait SoftDelete {

    public function delete(): bool {
        $database = new Database();

        $tablename = self::getTablenameFromClass();

        $result = $database->query("UPDATE $tablename SET deleted_at = CURRENT_TIME() WHERE id = ?", ['i:id' => $this->id]);
        return $result;
    }
}