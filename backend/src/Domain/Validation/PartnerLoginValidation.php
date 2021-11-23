<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\PartnerRepository;
use App\Domain\Repository\PartnerPassRepository;

class PartnerLoginValidation {
    private $partnerRepository;
    private $partnerPassRepository;

    public function __construct(PartnerRepository $partnerRepository, PartnerPassRepository $partnerPassRepository) {
        $this->partnerRepository = $partnerRepository;      
        $this->partnerPassRepository = $partnerPassRepository;       
    }

    public function validateRequest($body) {
        if (empty($body['dni'])) {
            throw new Exception('Identificación requerida.');
        }
        if (empty($body['pass'])) {
            throw new Exception('Contraseña requerida.');
        }
    }

    public function validatePartnerLogin($body) {
        $partner = $this->partnerRepository->getPartnerByDni($body['dni']);
        if (count($partner) < 1) {
            throw new Exception('Identificación* y/o contraseña incorrectas.');
        }
        if ($partner[0]->active == false) {
            throw new Exception('Usuario inactivo.');
        }
        $partnerPass = $this->partnerPassRepository->getLastPartnerPass($partner[0]->idpartner);
        if ($partnerPass[0]->pass != $body['pass']) {
            throw new Exception('Identificación y/o contraseña* incorrectas.');
        }
    }
}