<?php

namespace App\Domain\Repository;

use Illuminate\Database\Connection;
// use Illuminate\Support\Str;

class MeetingPartnerRepository {
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function getMeetingsPartnersFilter($body) {
        $where = [];
        
        if(!empty($body)) {
            foreach($body as $key => $value ) {
                $item = [$key, '=', $value];
                if ($key == 'idmeeting' || $key == 'idpartner') {
                    $item = ['meetingspartners.' . $key, '=', $value];
                } 

                array_push($where, $item);
            }
        } 
        return $this->connection->table('meetingspartners')->join('meetings', 'meetingspartners.idmeeting', '=', 'meetings.idmeeting')
                                                           ->join('partners', 'meetingspartners.idpartner', '=', 'partners.idpartner')        
                                                           ->where($where)
                                                           ->get();
        
    }

    public function getMeetingPartnerById($idmeeting, $idpartner) {
        return $this->connection->table('meetingspartners')->where('idmeeting', '=', $idmeeting)
                                                           ->where('idpartner', '=', $idpartner)
                                                           ->get();
    }

    public function getMeetingPartnerByIdMeeting($idmeeting) {
        return $this->connection->table('meetingspartners')->where('idmeeting', '=', $idmeeting)
                                                           ->get();
    }

    public function createMeetingPartner($idmeeting, $idpartner) {
        $values = [
            'idmeeting' => $idmeeting,
            'idpartner' => $idpartner
        ];

        $this->connection->table('meetingspartners')->insert($values);
    }

    public function updateMeetingPartner($body) {
        $values = [];
        foreach($body as $key => $value ) {
            $values[$key] = $value;
        }
        if(!empty($body['paiddate'])) {
            $values['paidperiod'] = date("Y-m",strtotime($body['paiddate']));
        }

        $this->connection->table('meetingspartners')->where('idmeeting', '=', $body['idmeeting'])
                                                    ->where('idpartner', '=', $body['idpartner'])
                                                    ->update($values);
    }

}