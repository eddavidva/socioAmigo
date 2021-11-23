<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\FeeService;

class FeeController {
    private $service;

    public function __construct(FeeService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $result = $this->service->getFees();

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createFee($body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = $request->getParsedBody();
        $result = $this->service->updateFee($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function destroy(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $result = $this->service->deleteFee($id);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}