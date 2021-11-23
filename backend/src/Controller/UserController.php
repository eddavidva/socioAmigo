<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\UserService;

class UserController {
    private $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $result = $this->service->getUsers();

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function show(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $result = $this->service->getUserById($id);

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createUser($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = (array)$request->getParsedBody();
        $result = $this->service->updateUser($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}