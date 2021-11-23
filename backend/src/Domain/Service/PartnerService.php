<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\PartnerRepository;
use App\Domain\Repository\PartnerPassRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\PartnerValidation;

class PartnerService {
    private $partnerRepository;
    private $partnerPassRepository;
    private $responseHelper;
    private $validation;

    public function __construct(PartnerRepository $partnerRepository, PartnerPassRepository $partnerPassRepository, ResponseHelper $responseHelper, PartnerValidation $validation) {
        $this->partnerRepository = $partnerRepository;
        $this->partnerPassRepository = $partnerPassRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getPartners() {
        try {
            $data = $this->partnerRepository->getPartners();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function getPartnerById($id) {
        try {
            $data = $this->partnerRepository->getPartnerById($id);
            if (count($data) < 1) {
                throw new Exception("Socio no existe.");
            }
            return $this->responseHelper->getResponse($data[0]);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createPartner($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreatePartner($body);
           
            $newId = $this->partnerRepository->createPartner($body);
            $bodyPartnerPass = [
                'idpartner' => $newId,
                'pass' => $body['dni']
            ];
            $this->partnerPassRepository->createPartnerPass($bodyPartnerPass);

            // Logging here: Partner created successfully
            // $this->logger->info(sprintf('Partner created successfully: %s', $partnerId));
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
    
    public function updatePartner($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdatePartner($id, $body);

            $this->partnerRepository->updatePartner($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}