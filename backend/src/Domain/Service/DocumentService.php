<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\DocumentRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\DocumentValidation;

class DocumentService {
    private $documentRepository;
    private $responseHelper;
    private $validation;

    public function __construct(DocumentRepository $documentRepository, ResponseHelper $responseHelper, DocumentValidation $validation) {
        $this->documentRepository = $documentRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getDocumentsFilter($body) {
        try {
            $data = $this->documentRepository->getDocumentsFilter($body);
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }


    public function createDocument($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateDocument($body);
           
            $this->documentRepository->createDocument($body);

            // Logging here: Document created successfully
            // $this->logger->info(sprintf('Document created successfully: %s', $documentId));
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
    
    public function updateDocument($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateDocument($id, $body);

            $this->documentRepository->updateDocument($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function deleteDocument($id) {
        try {

            $this->documentRepository->deleteDocument($id);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}