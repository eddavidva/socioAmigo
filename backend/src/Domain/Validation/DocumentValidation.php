<?php

namespace App\Domain\Validation;

use App\Domain\Repository\DocumentRepository;
use App\Domain\Repository\PartnerRepository;
use Exception;

class DocumentValidation {

    private $documentRepository;
    private $partnerRepository;

    public function __construct(DocumentRepository $documentRepository, PartnerRepository $partnerRepository) {
        $this->documentRepository = $documentRepository;
        $this->partnerRepository = $partnerRepository;
    }

    public function validateRequest($body) {
        if (empty($body['type'])) {
            throw new Exception('Tipo requerido.');
        } else if (!preg_match('/^[\p{L} ]+$/u', $body['type'])) {
            throw new Exception('Tipo incorrecto. ingrese únicamente letras.');
        }
        if (empty($body['documenttype'])) {
            throw new Exception('Tipo de documento requerido.');
        } else if (!preg_match('/^[\p{L} ]+$/u', $body['documenttype'])) {
            throw new Exception('Tipo de documento incorrecto. ingrese únicamente letras.');
        }
        if (empty($body['documentnumber'])) {
            throw new Exception('Número de documento requerido.');
        }
        if (empty($body['name'])) {
            throw new Exception('Nombre requerido.');
        } else if (!preg_match('/^[\p{L} ]+$/u', $body['name'])) {
            throw new Exception('Nombre incorrecto. ingrese únicamente letras.');
        }
        if (empty($body['dni'])) {
            throw new Exception('Identificación requerida.');
        } else if (strlen($body['dni']) < 10) {
            throw new Exception('Identificación incorrecta, debe contener al menos 10 dígitos.');
        } else if (!preg_match('/^[0-9]+$/i', $body['dni'])) {
            throw new Exception('Identificación incorrecta, ingrese únicamente números');
        }
        if (empty($body['address'])) {
            throw new Exception('Dirección requerida.');
        }
        if (empty($body['mobil'])) {
            throw new Exception('Celular requerido.');
        } else if (strlen($body['mobil']) != 10) {
            throw new Exception('Celular incorrecto, debe contener 10 dígitos.');
        } else if (!preg_match('/^[0-9]+$/i', $body['mobil'])) {
            throw new Exception('Celular incorrecto, ingrese únicamente números');
        }
        if (empty($body['description'])) {
            throw new Exception('Resumen requerido.');
        }
        if (isset($body['rate']) && !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $body['rate'])) {
            throw new Exception('Tarifa 0 incorrecta. ingrese en formato 00.00');
        }
        if (isset($body['rateiva']) && !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $body['rateiva'])) {
            throw new Exception('Tarifa IVA incorrecta. ingrese en formato 00.00');
        }
        if (isset($body['iva']) && !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $body['iva'])) {
            throw new Exception('IVA incorrecto. ingrese en formato 00.00');
        }
        if (isset($body['discount']) && !preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $body['discount'])) {
            throw new Exception('Descuento incorrecto. ingrese en formato 00.00');
        }
    }

    public function validateCreateDocument($body) {
        $document = $this->documentRepository->getDocumentByNumber($body['type'], $body['dni'], $body['documentnumber']);
        if (count($document) > 0 && $document[0]->status != 'Cancelado') {
            throw new Exception('Documento ya existe.');
        }
    }

    public function validateUpdateDocument($id, $body) {
        if (empty($body['iddocument']) || $body['iddocument'] == 0) {
            throw new Exception('Documento no autorizada.');
        }

        $documentId = $this->documentRepository->getDocumentById($id);
        $documentNumber = $this->documentRepository->getDocumentByNumber($body['type'], $body['dni'], $body['documentnumber']);

        if ($body['iddocument'] != $id) {
            throw new Exception('Documento no autorizado.');
        }
        if (count($documentId) < 1) {
            throw new Exception('Documento no existe.');
        }
        if ($documentId[0]->status == "Aprobado") {
            throw new Exception('Documento no puede ser modificado.');
        }
        if (count($documentNumber) > 0) {
            if ($documentId[0]->iddocument != $documentNumber[0]->iddocument) {
                throw new Exception('Documento ya existe.');
            }
        }
    }
}