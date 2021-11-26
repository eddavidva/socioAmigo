<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Service\MeetingPartnerService;

class MeetingPartnerController {
    private $service;

    public function __construct(MeetingPartnerService $service) {
        $this->service = $service;
    }

    public function index(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->getMeetingsPartnersFilter($body);

        $response->getBody()->write(json_encode($result));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->status);                  
    }

    // public function show(Request $request, Response $response): Response {
    //     $body = $request->getParsedBody();
    //     $result = $this->service->getMeetingPartnerById($body);

    //     $response->getBody()->write(json_encode($result));
    //     return $response
    //         ->withHeader('Content-Type', 'application/json')
    //         ->withStatus($result->status);
    // }

    public function create(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->createMeetingPartner($body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    public function edit(Request $request, Response $response): Response {
        $body = $request->getParsedBody();
        $result = $this->service->updateMeetingPartner($body);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($result->status);
    }

    // public function destroy(Request $request, Response $response, array $args): Response {
    //     $id = $args['id'];
    //     $result = $this->service->deleteMeetingPartner($id);
    //     $result = $this->service->deleteMeetingPartner($id);

    //     $response->getBody()->write(json_encode($result));
    //     return $response
    //         ->withHeader('Content-Type', 'application/json')
    //         ->withStatus($result->status);
    // }
}