<?php

namespace App\Domain\Validation;

use App\Domain\Repository\UserRepository;
use App\Domain\Repository\RoleRepository;
use Exception;

class UserValidation {

    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function validateRequest($body) {
        if (empty($body['idrole']) || $body['idrole'] == 0) {
            throw new Exception('Rol requerido.');
        }

        if (empty($body['nameuser'])) {
            throw new Exception('Nombre requerido.');
        } else if (!preg_match('/^[\p{L} ]+$/u', $body['nameuser'])) {
            throw new Exception('Nombre incorrecto. ingrese únicamente letras.');
        }

        if (empty($body['email'])) {
            throw new Exception('Email requerido.');
        } elseif (filter_var($body['email'], FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('Email incorrecto.');
        }

        if (!empty($body['mobil'])) {
            if (strlen($body['mobil']) != 10) {
                throw new Exception('Celular incorrecto, debe contener 10 dígitos.');
            } else if (!preg_match('/^[0-9]+$/i', $body['mobil'])) {
                throw new Exception('Celular incorrecto, ingrese únicamente números');
            }
        }

        $this->validateRole($body['idrole']);
    }

    public function validateCreateUser($body) {
        $user = $this->userRepository->getUserByEmail($body['email']);
        if (count($user) > 0) {
            throw new Exception('Usuario ya existe.');
        }
    }

    public function validateUpdateUser($id, $body) {
        if (empty($body['iduser']) || $body['iduser'] == 0) {
            throw new Exception('Usuario no autorizado.');
        }

        $userId = $this->userRepository->getUserById($id);
        $userEmail = $this->userRepository->getUserByEmail($body['email']);

        if ($body['iduser'] != $id) {
            throw new Exception('Usuario no autorizado.');
        }
        if (count($userId) < 1) {
            throw new Exception('Usuario no existe.');
        }
        if (count($userEmail) > 0) {
            if ($userId[0]->iduser != $userEmail[0]->iduser) {
                throw new Exception('Usuario ya existe.');
            }
        }
    }

    private function validateRole($idrole) {
        $role = $this->roleRepository->getRoleById($idrole);
        if (count($role) < 1) {
            throw new Exception('Rol no existe.');
        } 
    }
}