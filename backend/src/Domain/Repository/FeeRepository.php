<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;
use Illuminate\Support\Str;

class FeeRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getFees() {
        return $this->connection->table('fees')->get();
    }

    public function getFeeById($id) {
        return $this->connection->table('fees')->where('idfee', '=', $id)->get();
    }

    public function getFeeByName($name) {
        return $this->connection->table('fees')->where(Str::lower('namefee'), '=', $name)->get();
    }

    public function createFee($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        $values['period'] = date("Y-m",strtotime($body['expiresin']));

        $this->connection->table('fees')->insert($values);
    }

    public function updateFee($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        $values['period'] = date("Y-m",strtotime($body['expiresin']));

        $this->connection->table('fees')->where(['idfee' => $id])->update($values);
    }

    public function updateStateFee($id, $status) {
        $values = [
            'status' => $status
        ];
        $this->connection->table('fees')->where(['idfee' => $id])->update($values);
    }

    public function deleteFee($id) {
        $values = [
            'status' => 'Cancelada'
        ];

        $this->connection->table('fees')->where(['idfee' => $id])->update($values);
    }

}