<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\AssociationRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\AssociationValidation;

class AssociationService {
    private $associationRepository;
    private $responseHelper;
    private $validation;

    public function __construct(AssociationRepository $associationRepository, ResponseHelper $responseHelper, AssociationValidation $validation) {
        $this->associationRepository = $associationRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getAssociations() {
        try {
            $data = $this->associationRepository->getAssociations();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }


    public function createAssociation($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateAssociation($body);
           
            $this->associationRepository->createAssociation($body);

            // Logging here: Association created successfully
            // $this->logger->info(sprintf('Association created successfully: %s', $associationId));
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
    
    public function updateAssociation($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateAssociation($id, $body);

            $this->associationRepository->updateAssociation($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}