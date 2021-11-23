<?php

namespace App\Domain\Repository;

// use PDO;
use Illuminate\Database\Connection;


class PartnerRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getPartners() {
        return $this->connection->table('partners')->get();
    }

    public function getPartnerById($id) {
        return $this->connection->table('partners')->where('idpartner', '=', $id)->get();
    }

    public function getPartnerByDni($dni) {
        return $this->connection->table('partners')->where('dni', '=', $dni)->get();
    }

    public function createPartner($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        return $this->connection->table('partners')->insertGetId($values);
        // $this->connection->table('partners')->insert($values);
    }

    public function updatePartner($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('partners')->where(['idpartner' => $id])->update($values);
    }
}