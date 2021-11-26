<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\MeetingRepository;

class MeetingValidation {
    private $repository;

    public function __construct(MeetingRepository $repository) {
        $this->repository = $repository;
    }

    public function validateRequest($body) {
        if(empty($body['namemeeting'])) {
            throw new Exception('Nombre requerido.');
        }
        if(empty($body['datemeeting'])) {
            throw new Exception('Fecha de reunión requerida.');
        }
    }

    public function validateCreateMeeting($body) {
        $meeting = $this->repository->getMeetingByName(mb_strtolower($body['namemeeting']));
        if(count($meeting) > 0) {
            throw new Exception('Reunión ya existe.');
        }
    }

    public function validateUpdateMeeting($id, $body) {
        $meetingId = $this->repository->getMeetingById($id);
        $meetingName = $this->repository->getMeetingByName(mb_strtolower($body['namemeeting']));

        if ($body['idmeeting'] != $id) {
            throw new Exception('Reunión no autorizada.');
        }
        if (count($meetingId) < 1) {
            throw new Exception('Reunión no existe.');
        }
        if (count($meetingName) > 0) {
            if ($meetingId[0]->idmeeting != $meetingName[0]->idmeeting) {
                throw new Exception('Reunión ya existe.');
            }
        }
    }
}