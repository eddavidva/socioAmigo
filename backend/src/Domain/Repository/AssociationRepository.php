<?php

namespace App\Domain\Repository;

// use PDO;
use Illuminate\Database\Connection;
use Illuminate\Support\Str;


class AssociationRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getAssociations() {
        return $this->connection->table('associations')->get();
    }

    public function getAssociationById($id) {
        return $this->connection->table('associations')->where('idassociation', '=', $id)->get();
    }

    public function getAssociationByName($name) {
        return $this->connection->table('associations')->where(Str::lower('name'), '=', $name)->get();
    }

    public function createAssociation($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        // return $this->connection->table('associations')->insertGetId($values);
        $this->connection->table('associations')->insert($values);
    }

    public function updateAssociation($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('associations')->where(['idassociation' => $id])->update($values);
    }
}