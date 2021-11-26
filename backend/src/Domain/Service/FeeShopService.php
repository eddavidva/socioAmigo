<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\FeeShopRepository;
use App\Domain\Repository\ShopRepository;
use App\Domain\Repository\FeeRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\FeeShopValidation;

class FeeShopService {
    private $feeShopRepository;
    private $shopRepository;
    private $feeRepository;
    private $responseHelper;
    private $validation;

    public function __construct(FeeShopRepository $feeShopRepository, ShopRepository $shopRepository, FeeRepository $feeRepository, ResponseHelper $responseHelper, FeeShopValidation $validation) {
        $this->feeShopRepository = $feeShopRepository;
        $this->shopRepository = $shopRepository;
        $this->feeRepository = $feeRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getFeesShopsFilter($body) {
        try {
            $data = $this->feeShopRepository->getFeesShopsFilter($body);
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function getFeeShopById($id) {
        try {
            $feeshop = $this->feeShopRepository->getFeeShopById($id);
            if (count($feeshop) < 1) {
                throw new Exception("Cuota asignada no existe.");
            }
            $fee = $this->feeRepository->getFeeById($feeshop[0]->idfee);

            $data = [
                'fee'=> $fee[0],
                'feeshop'=> $feeshop[0]
            ];

            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createFeeShop($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateFeeShop($body);

            $shops = $this->shopRepository->getShops();
            for ($i = 0; $i < count($shops); $i++) {
                $this->feeShopRepository->createFeeShop($body['idfee'], $shops[$i]->idshop);
            }

            $this->feeRepository->updateStateFee($body['idfee'], 'Enviada');
            
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function updateFeeShop($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateFeeShop($body);

            $this->feeShopRepository->updateFeeShop($body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    // public function deleteFeeShop($id) {
    //     try {

    //         $this->repository->deleteFeeShop($id);
    //         return $this->responseHelper->getResponse();
    //     } catch (Exception $e) {
    //         return $this->responseHelper->getExceptionResponse($e);
    //     }
    // }

}
