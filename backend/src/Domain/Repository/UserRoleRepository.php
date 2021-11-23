<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;

class UserRoleRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function createUserRole($body) {
        $values = [
            'iduser' => $body['iduser'],
            'pass' => $body['pass'],
        ];

        $this->connection->table('userspass')->insert($values);
    }
}