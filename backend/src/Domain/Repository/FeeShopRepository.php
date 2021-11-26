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

        if(!empty($body)) {
            foreach($body as $key => $value ) {
                $item = [$key, '=', $value];
                if ($key == 'idfee' || $key == 'idshop') {
                    $item = ['feesshops.' . $key, '=', $value];
                }
                if ($key == 'idpartner') {
                    $item = ['shops.' . $key, '=', $value];
                }

                array_push($where, $item);
            }
            
        } 
        return $this->connection->table('feesshops')->join('fees', 'feesshops.idfee', '=', 'fees.idfee')
                                                    ->join('shops', 'feesshops.idshop', '=', 'shops.idshop')
                                                    ->join('partners', 'shops.idpartner', '=', 'partners.idpartner')
                                                    ->where($where)
                                                    ->get();
    }

    public function getFeeShopById($idfee, $idshop) {
        return $this->connection->table('feesshops')->where('idfee', '=', $idfee)
                                                    ->where('idshop', '=', $idshop)
                                                    ->get();
    }

    public function getFeeShopByIdFee($idfee) {
        return $this->connection->table('feesshops')->where('idfee', '=', $idfee)
                                                    ->get();
    }

    public function createFeeShop($idfee, $idshop) {
        $values = [
            'idfee' => $idfee,
            'idshop' => $idshop
        ];

        $this->connection->table('feesshops')->insert($values);
    }

    public function updateFeeShop($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        if(!empty($body['paiddate'])) {
            $values['paidperiod'] = date("Y-m",strtotime($body['paiddate']));
        }

        $this->connection->table('feesshops')->where('idfee', '=', $body['idfee'])
                                             ->where('idshop', '=', $body['idshop'])
                                             ->update($values);
    }

}