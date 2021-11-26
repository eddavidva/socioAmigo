<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\MeetingPartnerRepository;
use App\Domain\Repository\PartnerRepository;
use App\Domain\Repository\MeetingRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\MeetingPartnerValidation;

class MeetingPartnerService {
    private $meetingPartnerRepository;
    private $partnerRepository;
    private $meetingRepository;
    private $responseHelper;
    private $validation;

    public function __construct(MeetingPartnerRepository $meetingPartnerRepository, PartnerRepository $partnerRepository, MeetingRepository $meetingRepository, ResponseHelper $responseHelper, MeetingPartnerValidation $validation) {
        $this->meetingPartnerRepository = $meetingPartnerRepository;
        $this->partnerRepository = $partnerRepository;
        $this->meetingRepository = $meetingRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getMeetingsPartnersFilter($body) {
        try {
            $data = $this->meetingPartnerRepository->getMeetingsPartnersFilter($body);
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    // public function getMeetingPartnerById($body) {
    //     try {
    //         $meetingpartner = $this->meetingPartnerRepository->getMeetingPartnerById($body['idmeeting'], $body['idpartner']);
    //         if (count($meetingpartner) < 1) {
    //             throw new Exception("Reunión asignada no existe.");
    //         }
    //         $meeting = $this->meetingRepository->getMeetingById($meetingpartner[0]->idmeeting);

    //         $data = [
    //             'meeting'=> $meeting[0],
    //             'meetingpartner'=> $meetingpartner[0]
    //         ];

    //         return $this->responseHelper->getResponse($data);
    //     } catch (Exception $e) {
    //         return $this->responseHelper->getExceptionResponse($e);
    //     }
    // }

    public function createMeetingPartner($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateMeetingPartner($body);

            $partners = $this->partnerRepository->getPartners();
            for ($i = 0; $i < count($partners); $i++) {
                $this->meetingPartnerRepository->createMeetingPartner($body['idmeeting'], $partners[$i]->idpartner);
            }

            $this->meetingRepository->updateStateMeeting($body['idmeeting'], 'Enviada');
            
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function updateMeetingPartner($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateMeetingPartner($body);

            $this->meetingPartnerRepository->updateMeetingPartner($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    // public function deleteMeetingPartner($id) {
    //     try {

    //         $this->repository->deleteMeetingPartner($id);
    //         return $this->responseHelper->getResponse();
    //     } catch (Exception $e) {
    //         return $this->responseHelper->getExceptionResponse($e);
    //     }
    // }

}
