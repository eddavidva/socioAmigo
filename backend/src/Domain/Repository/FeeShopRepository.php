<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;
// use Illuminate\Support\Str;

class FeeShopRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getFeesShopsFilter($body) {
        $where = [];
        foreach($body as $key => $value ) {
            array_push($where, [$key, '=', $value]);
        }

        return $this->connection->table('feesshops')->where($where)->get();
    }

    public function getFeeShopById($id) {
        return $this->connection->table('feesshops')->where('idfeeshop', '=', $id)->get();
    }

    public function createFeeShop($idfee, $idshop, $idpartner) {
        $values = [
            'idfee' => $idfee,
            'idshop' => $idshop,
            'idpartner' => $idpartner
        ];

        $this->connection->table('feesshops')->insert($values);
    }

    public function updateFeeShop($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        $values["paidperiod"] = date("Y");

        $this->connection->table('feesshops')->where(['idfeeshop' => $id])->update($values);
    }

}