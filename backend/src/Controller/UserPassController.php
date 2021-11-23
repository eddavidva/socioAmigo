<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\UserPassService;


class UserPassController {
    private $service;

    public function __construct(UserPassService $service) {
        $this->service = $service;
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createUserPass($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}