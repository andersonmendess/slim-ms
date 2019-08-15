<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response) {

    $response->getBody()->write('Hello World');
    return $response;
});


$app->group('/v1', function($gp){

    $gp->get('/users', '\App\v1\Controllers\UserController:listUser');

    $gp->post('/users', '\App\v1\Controllers\UserController:createUser');


});