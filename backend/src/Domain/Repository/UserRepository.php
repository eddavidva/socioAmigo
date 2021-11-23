<?php

namespace App\Domain\Repository;

// use PDO;
use Illuminate\Database\Connection;


class UserRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getUsers() {
        return $this->connection->table('users')->get();
    }

    public function getUserById($id) {
        return $this->connection->table('users')->where('iduser', '=', $id)->get();
    }

    public function getUserByEmail($email) {
        return $this->connection->table('users')->where('email', '=', $email)->get();
    }

    public function createUser($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        return $this->connection->table('users')->insertGetId($values);
        // $this->connection->table('users')->insert($values);
    }

    public function updateUser($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('users')->where(['iduser' => $id])->update($values);
    }
}