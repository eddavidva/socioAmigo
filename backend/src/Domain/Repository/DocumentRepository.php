<?php

namespace App\Domain\Repository;

// use PDO;
use Illuminate\Database\Connection;
use Illuminate\Support\Str;


class DocumentRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getDocumentsFilter($body) {
        $where = [];
        foreach($body as $key => $value ) {
            array_push($where, [$key, '=', $value]);
        }

        return $this->connection->table('documents')->where($where)->get();
    }

    public function getDocumentById($id) {
        return $this->connection->table('documents')->where('iddocument', '=', $id)->get();
    }

    public function getDocumentByNumber($type, $dni ,$documentnumber) {
        $where = [
            [Str::lower('type'), '=', mb_strtolower($type)],
            ['dni', '=', $dni],
            [Str::lower('documentnumber'), '=', $documentnumber]
        ];
        return $this->connection->table('documents')->where($where)
                                                    ->orderBy('created', 'desc')
                                                    ->take(1)
                                                    ->get();
    }

    public function createDocument($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('documents')->insert($values);
    }

    public function updateDocument($id, $body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }

        $this->connection->table('documents')->where(['iddocument' => $id])->update($values);
    }

    public function deleteDocument($id) {
        $values = [
            'state' => 'Cancelado'
        ];

        $this->connection->table('documents')->where(['iddocument' => $id])->update($values);
    }
}