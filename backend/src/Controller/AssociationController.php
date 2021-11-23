<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\AssociationService;

class AssociationController {
    private $service;

    public function __construct(AssociationService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $result = $this->service->getAssociations();

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createAssociation($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = (array)$request->getParsedBody();
        $result = $this->service->updateAssociation($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}