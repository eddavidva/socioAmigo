<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\FeeRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\FeeValidation;

class FeeService {
    private $repository;
    private $responseHelper;
    private $validation;

    public function __construct(FeeRepository $repository, ResponseHelper $responseHelper, FeeValidation $validation) {
        $this->repository = $repository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getFees() {
        try {
            $data = $this->repository->getFees();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createFee($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateFee($body);
            
            $this->repository->createFee($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function updateFee($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateFee($id, $body);

            $this->repository->updateFee($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function deleteFee($id) {
        try {

            $this->repository->deleteFee($id);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

}
