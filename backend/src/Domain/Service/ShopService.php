<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\ShopRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\ShopValidation;

class ShopService {
    private $shopRepository;
    private $responseHelper;
    private $validation;

    public function __construct(ShopRepository $shopRepository, ResponseHelper $responseHelper, ShopValidation $validation) {
        $this->shopRepository = $shopRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getShops() {
        try {
            $data = $this->shopRepository->getShops();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }


    public function createShop($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateShop($body);
           
            $this->shopRepository->createShop($body);

            // Logging here: Shop created successfully
            // $this->logger->info(sprintf('Shop created successfully: %s', $shopId));
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
    
    public function updateShop($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateShop($id, $body);

            $this->shopRepository->updateShop($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}