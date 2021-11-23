<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserPassRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\UserValidation;

class UserService {
    private $userRepository;
    private $userPassRepository;
    private $responseHelper;
    private $validation;

    public function __construct(UserRepository $userRepository, UserPassRepository $userPassRepository, ResponseHelper $responseHelper, UserValidation $validation) {
        $this->userRepository = $userRepository;
        $this->userPassRepository = $userPassRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function getUsers() {
        try {
            $data = $this->userRepository->getUsers();
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function getUserById($id) {
        try {
            $data = $this->userRepository->getUserById($id);
            if (count($data) < 1) {
                throw new Exception("Usuario no existe.");
            }
            return $this->responseHelper->getResponse($data[0]);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }

    public function createUser($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateCreateUser($body);
           
            $newId = $this->userRepository->createUser($body);
            $bodyUserPass = [
                'iduser' => $newId,
                'pass' => $body['email']
            ];
            $this->userPassRepository->createUserPass($bodyUserPass);

            // Logging here: User created successfully
            // $this->logger->info(sprintf('User created successfully: %s', $userId));
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
    
    public function updateUser($id, $body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUpdateUser($id, $body);

            $this->userRepository->updateUser($id, $body);
            return $this->responseHelper->getResponse();
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}