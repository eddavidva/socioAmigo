<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;

class PartnerPassRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getPartnerPass($idpartner, $pass) {
        return $this->connection->table('partnerspass')->where('idpartner', '=', $idpartner)
                                                    ->where('pass', '=', $pass)
                                                    ->get();
    }

    public function getLastPartnerPass($idpartner) {
        return $this->connection->table('partnerspass')->where('idpartner', '=', $idpartner)
                                                    ->orderBy('created', 'desc')
                                                    ->take(1)
                                                    ->get();
    }

    public function createPartnerPass($body) {
        $values = [
            'idpartner' => $body['idpartner'],
            'pass' => $body['pass'],
        ];

        $this->connection->table('partnerspass')->insert($values);
    }
}
