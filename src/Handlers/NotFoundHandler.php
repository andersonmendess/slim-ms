<?php
namespace App\Handlers;

class NotFoundHandler {

    private $container;

    public function __construct($container){
       $this->container = $container;
    }
 
    public function __invoke($request, $response) {

       return $this->container['response']
            ->withJson(['message' => 'Not found 404', 'status' => 404], 404);
    }
}