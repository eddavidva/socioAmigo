<?php

namespace App\Domain\Validation;

use App\Domain\Repository\ShopRepository;
use App\Domain\Repository\PartnerRepository;
use App\Domain\Repository\AssociationRepository;
use Exception;

class ShopValidation {

    private $shopRepository;
    private $partnerRepository;
    private $associationRepository;

    public function __construct(ShopRepository $shopRepository, PartnerRepository $partnerRepository, AssociationRepository $associationRepository) {
        $this->shopRepository = $shopRepository;
        $this->partnerRepository = $partnerRepository;
        $this->associationRepository = $associationRepository;
    }

    public function validateRequest($body) {
        if (empty($body['idpartner']) || $body['idpartner'] == 0) {
            throw new Exception('Socio requerido.');
        }
        if (empty($body['idassociation']) || $body['idassociation'] == 0) {
            throw new Exception('Asociación requerida.');
        }
        if (empty($body['location'])) {
            throw new Exception('Ubicación requerida.');
        }
        if (empty($body['number'])) {
            throw new Exception('Número requerido.');
        }
        if (empty($body['name'])) {
            throw new Exception('Nombre requerido.');
        }
        $this->validatePartner($body['idpartner']);
        $this->validateAssociation($body['idassociation']);
    }

    public function validateCreateShop($body) {
        $shop = $this->shopRepository->getShopByNumber($body['location'], $body['number']);
        if (count($shop) > 0) {
            throw new Exception('Local ya existe.');
        }
    }

    public function validateUpdateShop($id, $body) {
        if (empty($body['idshop']) || $body['idshop'] == 0) {
            throw new Exception('Local no autorizado.');
        }

        $shopId = $this->shopRepository->getShopById($id);
        $shopNumber = $this->shopRepository->getShopByNumber($body['location'], $body['number']);

        if ($body['idshop'] != $id) {
            throw new Exception('Local no autorizado.');
        }
        if (count($shopId) < 1) {
            throw new Exception('Local no existe.');
        }
        if (count($shopNumber) > 0) {
            if ($shopId[0]->idshop != $shopNumber[0]->idshop) {
                throw new Exception('Local ya existe.');
            }
        }
    }

    private function validatePartner($idpartner) {
        $partner = $this->partnerRepository->getPartnerById($idpartner);
        if (count($partner) < 1) {
            throw new Exception('Socio no existe.');
        } 
    }
    
    private function validateAssociation($idassociation) {
        $association = $this->associationRepository->getAssociationById($idassociation);
        if (count($association) < 1) {
            throw new Exception('Asociación no existe.');
        } 
    }
}