<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\UserLoginService;

class UserLoginController {
    private $service;

    public function __construct(UserLoginService $service) {
        $this->service = $service;
    }

    public function create(Request $request, Response $response) {
        $body = $request->getParsedBody();
        $result = $this->service->userLogin($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

}