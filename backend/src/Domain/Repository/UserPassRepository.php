<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;

class UserPassRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getUserPass($iduser, $pass) {
        return $this->connection->table('userspass')->where('iduser', '=', $iduser)
                                                    ->where('pass', '=', $pass)
                                                    ->get();
    }

    public function getLastUserPass($iduser) {
        return $this->connection->table('userspass')->where('iduser', '=', $iduser)
                                                    ->orderBy('created', 'desc')
                                                    ->take(1)
                                                    ->get();
    }

    public function createUserPass($body) {
        $values = [
            'iduser' => $body['iduser'],
            'pass' => $body['pass'],
        ];

        $this->connection->table('userspass')->insert($values);
    }
}
