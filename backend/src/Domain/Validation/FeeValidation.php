<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\FeeRepository;

class FeeValidation {
    private $repository;

    public function __construct(FeeRepository $repository) {
        $this->repository = $repository;
    }

    public function validateRequest($body) {
        if(empty($body['namefee'])) {
            throw new Exception('Nombre requerido.');
        }
        if(empty($body['expiresin'])) {
            throw new Exception('Fecha de vencimiento requerida.');
        }
        if($body['value'] == 0) {
            throw new Exception('Valor de la cuota requerido.');
        }
    }

    public function validateCreateFee($body) {
        $fee = $this->repository->getFeeByName(mb_strtolower($body['namefee']));
        if(count($fee) > 0) {
            throw new Exception('Cuota ya existe.');
        }
    }

    public function validateUpdateFee($id, $body) {
        $feeId = $this->repository->getFeeById($id);
        $feeName = $this->repository->getFeeByName(mb_strtolower($body['namefee']));

        if ($body['idfee'] != $id) {
            throw new Exception('Cuota no autorizada.');
        }
        if (count($feeId) < 1) {
            throw new Exception('Cuota no existe.');
        }
        if (count($feeName) > 0) {
            if ($feeId[0]->idfee != $feeName[0]->idfee) {
                throw new Exception('Cuota ya existe.');
            }
        }
    }
}