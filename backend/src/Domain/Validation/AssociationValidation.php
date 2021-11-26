<?php

namespace App\Domain\Validation;

use App\Domain\Repository\AssociationRepository;
use App\Domain\Repository\PartnerRepository;
use Exception;

class AssociationValidation {

    private $associationRepository;
    private $partnerRepository;

    public function __construct(AssociationRepository $associationRepository, PartnerRepository $partnerRepository) {
        $this->associationRepository = $associationRepository;
        $this->partnerRepository = $partnerRepository;
    }

    public function validateRequest($body) {
        if (empty($body['idmanager']) || $body['idmanager'] == 0) {
            throw new Exception('Asociación Directivo requerido.');
        }

        if (empty($body['nameassociation'])) {
            throw new Exception('Nombre requerido.');
        }

        $this->validateManager($body['idmanager']);
    }

    public function validateCreateAssociation($body) {
        $association = $this->associationRepository->getAssociationByName($body['nameassociation']);
        if (count($association) > 0) {
            throw new Exception('Asociación ya existe.');
        }
    }

    public function validateUpdateAssociation($id, $body) {
        if (empty($body['idassociation']) || $body['idassociation'] == 0) {
            throw new Exception('Asociación no autorizada.');
        }

        $associationId = $this->associationRepository->getAssociationById($id);
        $associationName = $this->associationRepository->getAssociationByName($body['nameassociation']);

        if ($body['idassociation'] != $id) {
            throw new Exception('Asociación no autorizada.');
        }
        if (count($associationId) < 1) {
            throw new Exception('Asociación no existe.');
        }
        if (count($associationName) > 0) {
            if ($associationId[0]->idassociation != $associationName[0]->idassociation) {
                throw new Exception('Asociación ya existe.');
            }
        }
    }

    private function validateManager($idmanager) {
        $partner = $this->partnerRepository->getPartnerById($idmanager);
        if (count($partner) < 1) {
            throw new Exception('Socio no existe.');
        } 
    }
}