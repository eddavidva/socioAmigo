<?php

use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return function (App $app) {

    $app->group('/api', function (RouteCollectorProxy $group) {
        
        // ASSOCIATIONS
        $group->get('/association', '\App\Controller\AssociationController:index');
        $group->post('/association', '\App\Controller\AssociationController:create');
        $group->put('/association/{id}', '\App\Controller\AssociationController:edit');

        // DOCUMENTS
        $group->post('/document-filter', '\App\Controller\DocumentController:index');
        $group->post('/document', '\App\Controller\DocumentController:create');
        $group->put('/document/{id}', '\App\Controller\DocumentController:edit');
        $group->delete('/document/{id}', '\App\Controller\DocumentController:destroy');

        // FEE (cuotas)
        $group->get('/fee', '\App\Controller\FeeController:index');
        $group->post('/fee', '\App\Controller\FeeController:create');
        $group->put('/fee/{id}', '\App\Controller\FeeController:edit');
        $group->delete('/fee/{id}', '\App\Controller\FeeController:destroy');
        $group->get('/feeshop/{id}', '\App\Controller\FeeShopController:show');
        $group->post('/feeshop-filter', '\App\Controller\FeeShopController:index');
        $group->post('/feeshop', '\App\Controller\FeeShopController:create');
        $group->put('/feeshop/{id}', '\App\Controller\FeeShopController:edit');

        // MEETINGS
        $group->get('/meeting', '\App\Controller\MeetingController:index');
        $group->post('/meeting', '\App\Controller\MeetingController:create');
        $group->put('/meeting/{id}', '\App\Controller\MeetingController:edit');
        $group->delete('/meeting/{id}', '\App\Controller\MeetingController:destroy');

        // PARTNERS
        $group->post('/partnerlogin', '\App\Controller\PartnerLoginController:create');
        $group->get('/partner', '\App\Controller\PartnerController:index');
        $group->get('/partner/{id}', '\App\Controller\PartnerController:show');
        $group->post('/partner', '\App\Controller\PartnerController:create');
        $group->put('/partner/{id}', '\App\Controller\PartnerController:edit');
        $group->post('/partnerpass', '\App\Controller\PartnerPassController:create');

        // ROLES
        $group->get('/role', '\App\Controller\RoleController:index');
        $group->post('/role', '\App\Controller\RoleController:create');
        $group->put('/role/{id}', '\App\Controller\RoleController:edit');

         // SHOPS
        $group->get('/shop', '\App\Controller\ShopController:index');
        $group->post('/shop', '\App\Controller\ShopController:create');
        $group->put('/shop/{id}', '\App\Controller\ShopController:edit');

        // USERS
        $group->post('/userlogin', '\App\Controller\UserLoginController:create');
        $group->get('/user', '\App\Controller\UserController:index');
        $group->get('/user/{id}', '\App\Controller\UserController:show');
        $group->post('/user', '\App\Controller\UserController:create');
        $group->put('/user/{id}', '\App\Controller\UserController:edit');
        $group->post('/userpass', '\App\Controller\UserPassController:create');
    });
    
};
