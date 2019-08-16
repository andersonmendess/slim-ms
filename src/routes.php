<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $request, Response $response) {

    $response->getBody()->write('Hello World');
    return $response;
});


$app->group('/v1', function($gp){

    $gp->get('/users', '\App\v1\Controllers\UserController:list');
    $gp->get('/users/{id}', '\App\v1\Controllers\UserController:show');
    $gp->post('/users', '\App\v1\Controllers\UserController:create');
    $gp->put('/users/{id}', '\App\v1\Controllers\UserController:edit');
    $gp->delete('/users/{id}', '\App\v1\Controllers\UserController:delete');


});