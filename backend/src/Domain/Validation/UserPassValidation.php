<?php

namespace App\Domain\Validation;

use App\Domain\Repository\UserRepository;
use App\Domain\Repository\UserPassRepository;
use Exception;

class UserPassValidation {
    private $userRepository;
    private $repository;

    public function __construct(UserRepository $userRepository, UserPassRepository $repository) {
        $this->userRepository = $userRepository;
        $this->repository = $repository;
    }

    public function validateRequest($body) {

        if (empty($body['iduser'])) {
            throw new Exception('Usuario requerido');
        } else if ($body['iduser'] <= 0) {
            throw new Exception('Usuario no existe');
        } else if (filter_var($body['iduser'], FILTER_VALIDATE_INT) === false) {
            throw new Exception('Usuario no existe');
        }

        if (empty($body['pass'])) {
            throw new Exception('Contraseña requerida.');
        } else if (!preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $body['pass'])) {
            throw new Exception('Contraseña incorrecta, debe contener mínimo 8 caracteres, 1 mayúscula y 1 dígito.');
        }
    }

    public function validateUserPass($body) {
        $user = $this->userRepository->getUserById($body['iduser']);
        if (count($user) < 1) {
            throw new Exception("Usuario no existe.");
        }
        if ($user[0]->active == false) {
            throw new Exception('Usuario inactivo.');
        }
        $userPass = $this->repository->getUserPass($body['iduser'], $body['pass']);
        if (count($userPass) > 0) {
            throw new Exception('La contreseña no puede ser una de la anteriores.');
        }
    }
}