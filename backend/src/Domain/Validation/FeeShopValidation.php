<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\FeeShopRepository;
use App\Domain\Repository\FeeRepository;

class FeeShopValidation {
    private $feeShopRepository;

    public function __construct(FeeShopRepository $feeShopRepository, FeeRepository $feeRepository) {
        $this->feeShopRepository = $feeShopRepository;
        $this->feeRepository = $feeRepository;
    }

    public function validateRequest($body) {
        if(empty($body['idfee']) || $body['idfee'] == 0) {
            throw new Exception('Cuota requerida.');
        }
    }
    
    public function validateCreateFeeShop($body) {
        $fee = $this->feeRepository->getFeeById($body['idfee']);
        if(count($fee) < 1) {
            throw new Exception('Cuota no existe.');
        }
        if($fee[0]->state == 'Enviada' || $fee[0]->state == 'Cancelada') {
            throw new Exception('Cuota no puede ser asignada.');
        }
    }


    public function validateUpdateFeeShop($id, $body) {
        if (empty($body['idfeeshop']) || $body['idfeeshop'] == 0) {
            throw new Exception('Cuota asignada no autorizada.');
        }
        if ($id != $body['idfeeshop']) {
            throw new Exception('Cuota asignada no autorizada.');
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

        $feeshop = $this->feeShopRepository->getFeeShopById($body['idfeeshop']);
        if (count($feeshop) < 1 ) {
            throw new Exception('Cuota asignada no existe.');
        }
        $fee = $this->feeRepository->getFeeById($body['idfee']);
        if(count($fee) < 1) {
            throw new Exception('Cuota no existe.');
        }

    }
}