<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\FeeShopService;

class FeeShopController {
    private $service;

    public function __construct(FeeShopService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->getFeesShopsFilter($body);

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function show(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = $request->getParsedBody();
        $result = $this->service->getFeeShopById($id);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createFeeShop($body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = $request->getParsedBody();
        $result = $this->service->updateFeeShop($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    // public function destroy(Request $request, Response $response, array $args): Response {
    //     $id = $args['id'];
    //     $result = $this->service->deleteFeeShop($id);
    //     $result = $this->service->deleteFeeShop($id);

    //     $response->getBody()->write(json_encode($result));
    //     return $response
    //         ->withHeader('Content-Type', 'application/json')
    //         ->withStatus($result->status);
    // }
}