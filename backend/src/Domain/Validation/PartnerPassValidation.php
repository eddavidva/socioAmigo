<?php

namespace App\Domain\Validation;

use App\Domain\Repository\PartnerRepository;
use App\Domain\Repository\PartnerPassRepository;
use Exception;

class PartnerPassValidation {
    private $partnerRepository;
    private $repository;

    public function __construct(PartnerRepository $partnerRepository, PartnerPassRepository $repository) {
        $this->partnerRepository = $partnerRepository;
        $this->repository = $repository;
    }

    public function validateRequest($body) {

        if (empty($body['idpartner'])) {
            throw new Exception('Socio requerido');
        } else if ($body['idpartner'] <= 0) {
            throw new Exception('Socio no existe');
        } else if (filter_var($body['idpartner'], FILTER_VALIDATE_INT) === false) {
            throw new Exception('Socio no existe');
        }

        if (empty($body['pass'])) {
            throw new Exception('Contraseña requerida.');
        } else if (!preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $body['pass'])) {
            throw new Exception('Contraseña incorrecta, debe contener mínimo 8 caracteres, 1 mayúscula y 1 dígito.');
        }
    }

    public function validatePartnerPass($body) {
        $partner = $this->partnerRepository->getPartnerById($body['idpartner']);
        if (count($partner) < 1) {
            throw new Exception("Socio no existe.");
        }
        if ($partner[0]->active == false) {
            throw new Exception('Socio inactivo.');
        }
        $partnerPass = $this->repository->getPartnerPass($body['idpartner'], $body['pass']);
        if (count($partnerPass) > 0) {
            throw new Exception('La contreseña no puede ser una de la anteriores.');
        }
    }
}