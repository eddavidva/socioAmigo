<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\PartnerPassRepository;
use App\Domain\Validation\PartnerPassValidation;
use App\Helper\ResponseHelper;

class PartnerPassService {
    private $repository;
    private $responseHelper;
    private $validation;

    public function __construct(PartnerPassRepository $repository, ResponseHelper $responseHelper, PartnerPassValidation $validation) {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function createPartnerPass($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validatePartnerPass($body);

            $this->repository->createPartnerPass($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}