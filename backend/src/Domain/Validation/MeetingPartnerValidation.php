<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\MeetingPartnerRepository;
use App\Domain\Repository\MeetingRepository;
use App\Domain\Repository\PartnerRepository;

class MeetingPartnerValidation {
    private $meetingPartnerRepository;
    private $meetingRepository;
    private $partnerRepository;

    public function __construct(MeetingPartnerRepository $meetingPartnerRepository, MeetingRepository $meetingRepository, PartnerRepository $partnerRepository) {
        $this->meetingPartnerRepository = $meetingPartnerRepository;
        $this->meetingRepository = $meetingRepository;
        $this->partnerRepository = $partnerRepository;
    }

    public function validateRequest($body) {
        if(empty($body['idmeeting']) || $body['idmeeting'] == 0) {
            throw new Exception('Renunión requerida.');
        }

        $meeting = $this->meetingRepository->getMeetingById($body['idmeeting']);
        if(count($meeting) < 1) {
            throw new Exception('Renunión no existe.');
        }
    }
    
    public function validateCreateMeetingPartner($body) {
        $meetingPartner = $this->meetingPartnerRepository->getMeetingPartnerByIdMeeting($body['idmeeting']);
        if(count($meetingPartner) > 0) {
            throw new Exception('Renunión ya fue asignada.');
        }
    }


    public function validateUpdateMeetingPartner($body) {
        if (empty($body['idpartner']) || $body['idpartner'] == 0) {
            throw new Exception('Socio requerido.');
        }

        $partner = $this->partnerRepository->getPartnerById($body['idpartner']);
        if (count($partner) < 1 ) {
            throw new Exception('Socio no existe.');
        }
    }
}