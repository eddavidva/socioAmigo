<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserPassRepository;

class UserLoginValidation {
    private $userRepository;
    private $userPassRepository;

    public function __construct(UserRepository $userRepository, UserPassRepository $userPassRepository) {
        $this->userRepository = $userRepository;      
        $this->userPassRepository = $userPassRepository;       
    }

    public function validateRequest($body) {
        if (empty($body['email'])) {
            throw new Exception('Email requerida.');
        }
        if (empty($body['pass'])) {
            throw new Exception('Contraseña requerida.');
        }
    }

    public function validateUserLogin($body) {
        $user = $this->userRepository->getUserByEmail($body['email']);
        if (count($user) < 1) {
            throw new Exception('Email* y/o contraseña incorrectas.');
        }
        if ($user[0]->active == false) {
            throw new Exception('Usuario inactivo.');
        }
        $userPass = $this->userPassRepository->getLastUserPass($user[0]->iduser);
        if ($userPass[0]->pass != $body['pass']) {
            throw new Exception('Email y/o contraseña* incorrectas.');
        }
    }
}