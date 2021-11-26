<?php

namespace App\Domain\Validation;

use Exception;
use App\Domain\Repository\RoleRepository;

class RoleValidation {
    private $repository;

    public function __construct(RoleRepository $repository) {
        $this->repository = $repository;
    }

    public function validateRequest($body) {
        if(empty($body['namerole'])) {
            throw new Exception('Nombre requerido.');
        }
    }

    public function validateCreateRole($body) {
        $role = $this->repository->getRoleByName(mb_strtolower($body['namerole']));
        if(count($role) > 0) {
            throw new Exception('Rol ya existe.');
        }
    }

    public function validateUpdateRole($id, $body) {
        $roleId = $this->repository->getRoleById($id);
        $roleName = $this->repository->getRoleByName(mb_strtolower($body['namerole']));

        if ($body['idrole'] != $id) {
            throw new Exception('Rol no autorizado.');
        }
        if (count($roleId) < 1) {
            throw new Exception('Rol no existe.');
        }
        if (count($roleName) > 0) {
            if ($roleId[0]->idrole != $roleName[0]->idrole) {
                throw new Exception('Rol ya existe.');
            }
        }
    }
}