<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\PartnerRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\PartnerLoginValidation;


class PartnerLoginService {
    private $partnerRepository;
    private $responseHelper;
    private $validation;

    public function __construct(PartnerRepository $partnerRepository, ResponseHelper $responseHelper, PartnerLoginValidation $validation) {
        $this->partnerRepository = $partnerRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function partnerLogin($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validatePartnerLogin($body);

            $partner = $this->partnerRepository->getPartnerByDni($body['dni']);
            $data = [
                'token' => 'jasjajaabsaks.kasjaskahskhakshka.kjahskhakshakska',
                'partner' => $partner
            ];
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}