<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\UserPassRepository;
use App\Domain\Validation\UserPassValidation;
use App\Helper\ResponseHelper;

class UserPassService {
    private $repository;
    private $responseHelper;
    private $validation;

    public function __construct(UserPassRepository $repository, ResponseHelper $responseHelper, UserPassValidation $validation) {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function createUserPass($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUserPass($body);

            $this->repository->createUserPass($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}