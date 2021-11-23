<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\DocumentService;

class DocumentController {
    private $service;

    public function __construct(DocumentService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->getDocumentsFilter($body);

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createDocument($body);
        
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $body = (array)$request->getParsedBody();
        $result = $this->service->updateDocument($id, $body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function destroy(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $result = $this->service->deleteDocument($id);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }
}