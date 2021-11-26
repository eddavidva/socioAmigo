<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\MeetingRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\MeetingValidation;

class MeetingService {
    private $repository;
    private $responseHelper;
    private $validation;

    public function __construct(MeetingRepository $repository, ResponseHelper $responseHelper, MeetingValidation $validation) {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getMeetings() {
        try {
            $data = $this->repository->getMeetings();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createMeeting($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateMeeting($body);
            
            $this->repository->createMeeting($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function updateMeeting($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateMeeting($id, $body);

            $this->repository->updateMeeting($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function deleteMeeting($id) {
        try {

            $this->repository->deleteMeeting($id);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

}
