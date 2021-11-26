<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\FeeShopRepository;
use App\Domain\Repository\FeeRepository;
use App\Domain\Repository\ShopRepository;

class FeeShopValidation {
    private $feeShopRepository;
    private $feeRepository;
    private $shopRepository;

    public function __construct(FeeShopRepository $feeShopRepository, FeeRepository $feeRepository, ShopRepository $shopRepository) {
        $this->feeShopRepository = $feeShopRepository;
        $this->feeRepository = $feeRepository;
        $this->shopRepository = $shopRepository;
    }

    public function validateRequest($body) {
        if(empty($body['idfee']) || $body['idfee'] == 0) {
            throw new Exception('Cuota requerida.');
        }

        $fee = $this->feeRepository->getFeeById($body['idfee']);
        if(count($fee) < 1) {
            throw new Exception('Cuota no existe.');
        }
    }
    
    public function validateCreateFeeShop($body) {
        $feeshop = $this->feeShopRepository->getFeeShopByIdFee($body['idfee']);
        if(count($feeshop) > 0) {
            throw new Exception('La cuota ya fué asignada.');
        }
    }


    public function validateUpdateFeeShop($body) {
        if (empty($body['idshop']) || $body['idshop'] == 0) {
            throw new Exception('Local requerido.');
        }
        $shop = $this->shopRepository->getShopById($body['idshop']);
        if (count($shop) < 1 ) {
            throw new Exception('Local no existe.');
        }
        $feeshop = $this->feeShopRepository->getFeeShopById($body['idfee'], $body['idshop']);
        if (count($feeshop) < 1 ) {
            throw new Exception('Cuota asignada no existe.');
        }
        if (empty($body['paiddate'])) {
            throw new Exception('Fecha de pago requerida.');
        }
        if (empty($body['paidtype'])) {
            throw new Exception('Tipo de pago requerido.');
        }
        if (empty($body['paidvoucher'])) {
            throw new Exception('No. de comprobante de pago requerido.');
        }
        if($body['paidtype'] != 'Efectivo' && empty($body['paidimage'])) {
            throw new Exception('Imagen del comprobante de pago requerido.');
        }
    }
}