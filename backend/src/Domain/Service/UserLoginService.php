<?php

namespace App\Domain\Service;

use Exception;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\RoleMenuRepository;
use App\Helper\ResponseHelper;
use App\Domain\Validation\UserLoginValidation;


class UserLoginService {
    private $userRepository;
    private $roleMenuRepository;
    private $responseHelper;
    private $validation;

    public function __construct(UserRepository $userRepository, RoleMenuRepository $roleMenuRepository, ResponseHelper $responseHelper, UserLoginValidation $validation) {
        $this->userRepository = $userRepository;
        $this->roleMenuRepository = $roleMenuRepository;
        $this->responseHelper = $responseHelper;
        $this->validation = $validation;
    }

    public function userLogin($body) {
        try {
            $this->validation->validateRequest($body);
            $this->validation->validateUserLogin($body);

            $user = $this->userRepository->getUserByEmail($body['email']);
            $menu = $this->roleMenuRepository->getRoleMenuByIdRole($user[0]->idrole);
            $data = [
                'token' => 'jasjajaabsaks.kasjaskahskhakshka.kjahskhakshakska',
                'user' => $user,
                'menu' => $menu
            ];
            return $this->responseHelper->getResponse($data);
        } catch (Exception $e) {
            return $this->responseHelper->getExceptionResponse($e);
        }
    }
}