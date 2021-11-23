<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;
use Illuminate\Support\Str;

class RoleRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getRoles() {
        return $this->connection->table('roles')->get();
    }

    public function getRoleById($id) {
        return $this->connection->table('roles')->where('idrole', '=', $id)->get();
    }

    public function getRoleByName($name) {
        return $this->connection->table('roles')->where(Str::lower('name'), '=', $name)->get();
    }

    public function createRole($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('roles')->insert($values);
    }

    public function updateRole($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('roles')->where(['idrole' => $id])->update($values);
    }

}