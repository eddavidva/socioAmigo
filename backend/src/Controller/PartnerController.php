<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\PartnerService;

class PartnerController {
    private $service;

    public function __construct(PartnerService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $result = $this->service->getPartners();

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function show(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $result = $this->service->getPartnerById($id);

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createPartner($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = (array)$request->getParsedBody();
        $result = $this->service->updatePartner($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}