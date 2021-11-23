<?php

namespace App\Domain\Repository;

// use PDO;
use Illuminate\Database\Connection;
use Illuminate\Support\Str;


class ShopRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getShops() {
        return $this->connection->table('shops')->get();
    }

    public function getShopById($id) {
        return $this->connection->table('shops')->where('idshop', '=', $id)->get();
    }

    public function getShopByNumber($location, $number) {
        return $this->connection->table('shops')->where(Str::lower('location'), '=', $location)
                                                ->where(Str::lower('number'), '=', $number)
                                                ->get();
    }

    public function createShop($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        // return $this->connection->table('shops')->insertGetId($values);
        $this->connection->table('shops')->insert($values);
    }

    public function updateShop($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('shops')->where(['idshop' => $id])->update($values);
    }
}