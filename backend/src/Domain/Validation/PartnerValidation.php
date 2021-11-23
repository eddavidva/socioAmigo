<?php

namespace App\Domain\Validation;

use App\Domain\Repository\PartnerRepository;
use Exception;

class PartnerValidation {

    private $repository;

    public function __construct(PartnerRepository $repository) {
        $this->repository = $repository;
    }

    public function validateRequest($body) {

        if (empty($body['dni'])) {
            throw new Exception('Identificación requerida.');
        } else if (strlen($body['dni']) < 10) {
            throw new Exception('Identificación incorrecta, debe contener al menos 10 dígitos.');
        } else if (!preg_match('/^[0-9]+$/i', $body['dni'])) {
            throw new Exception('Identificación incorrecta, ingrese únicamente números');
        }

        if (empty($body['name'])) {
            throw new Exception('Nombre requerido.');
        } else if (!preg_match('/^[\p{L} ]+$/u', $body['name'])) {
            throw new Exception('Nombre incorrecto. ingrese únicamente letras.');
        }

        if (empty($body['mobil'])) {
            throw new Exception('Celular requerido.');
        } else if (strlen($body['mobil']) != 10) {
            throw new Exception('Celular incorrecto, debe contener 10 dígitos.');
        } else if (!preg_match('/^[0-9]+$/i', $body['mobil'])) {
            throw new Exception('Celular incorrecto, ingrese únicamente números');
        }
        
        if (!empty($body['email']) && filter_var($body['email'], FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('Email incorrecto.');
        }

        if (empty($body['address'])) {
            throw new Exception('Dirección requerida.');
        }
    }

    public function validateCreatePartner($body) {
        $partner = $this->repository->getPartnerByDni($body['dni']);
        if (count($partner) > 0) {
            throw new Exception('Socio ya existe.');
        }
    }

    public function validateUpdatePartner($id, $body) {
        if (empty($body['idpartner']) || $body['idpartner'] == 0) {
            throw new Exception('Socio no autorizado.');
        }
        
        $partnerId = $this->repository->getPartnerById($id);
        $partnerDni = $this->repository->getPartnerByDni($body['dni']);

        if ($body['idpartner'] != $id) {
            throw new Exception('Socio no autorizado.');
        }
        if (count($partnerId) < 1) {
            throw new Exception('Socio no existe.');
        }
        if (count($partnerDni) > 0) {
            if ($partnerId[0]->idpartner != $partnerDni[0]->idpartner) {
                throw new Exception('Socio ya existe.');
            }
        }
    }
}