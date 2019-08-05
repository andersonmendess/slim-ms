<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'bootstrap.php';

/**
 * get all books
 */
$app->get('/book', function (Request $request, Response $response) use ($app) {
    $return = $response->withJson(['msg' => 'books list'], 200);
    return $return;
});

/**
 * get a specific book
 */
$app->get('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    
    
    $return = $response->withJson(['msg' => "Details about book {$id}"], 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * create a new book
 */
$app->post('/book', function (Request $request, Response $response) use ($app) {
    $return = $response->withJson(['msg' => "Creating a new book"], 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * update a book
 */
$app->put('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    

    $return = $response->withJson(['msg' => "Updating the book {$id}"], 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/**
 * delete a book
 */
$app->delete('/book/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');    
    
    $return = $response->withJson(['msg' => "Deleting the book {$id}"], 204)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->run();