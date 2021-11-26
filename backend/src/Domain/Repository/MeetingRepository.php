<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;
use Illuminate\Support\Str;

class MeetingRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getMeetings() {
        return $this->connection->table('meetings')->get();
    }

    public function getMeetingById($id) {
        return $this->connection->table('meetings')->where('idmeeting', '=', $id)->get();
    }

    public function getMeetingByName($name) {
        return $this->connection->table('meetings')->where(Str::lower('namemeeting'), '=', $name)->get();
    }

    public function createMeeting($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        $values['period'] = date("Y-m",strtotime($body['datemeeting']));

        $this->connection->table('meetings')->insert($values);
    }

    public function updateMeeting($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        $values['period'] = date("Y-m",strtotime($body['datemeeting']));

        $this->connection->table('meetings')->where(['idmeeting' => $id])->update($values);
    }

    public function updateStateMeeting($id, $status) {
        $values = [
            'status' => $status
        ];
        $this->connection->table('meetings')->where(['idmeeting' => $id])->update($values);
    }

    public function deleteMeeting($id) {
        $values = [
            'status' => 'Cancelada'
        ];

        $this->connection->table('meetings')->where(['idmeeting' => $id])->update($values);
    }

}