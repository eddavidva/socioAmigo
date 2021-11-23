<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\RoleRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\RoleValidation;

class RoleService {
    private $repository;
    private $responseHelper;
    private $validation;

    public function __construct(RoleRepository $repository, ResponseHelper $responseHelper, RoleValidation $validation) {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getRoles() {
        try {
            $data = $this->repository->getRoles();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createRole($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateRole($body);
            
            $this->repository->createRole($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function updateRole($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateRole($id, $body);

            $this->repository->updateRole($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

}
